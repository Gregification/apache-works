#! /usr/bin/pwsh
#image -> php:7.2-apache
#note: this basically ignore source material from the dockerfile, update the linked volumes for folder changes

param (
    [switch]$visit          = $false,
    [switch]$visitOnly      = $false,
    [switch]$stop           = $false,
    [switch]$showCommand    = $false,
    [switch]$help           = $false,
    [switch]$removeSrcImage = $false,
    [switch]$showCommandOnly    = $false,
    [switch]$useIncovationPath  = $false,
    [switch]$interactive    = $false,
    [switch]$rebuild        = $false,
    [switch]$rebuilddb      = $false,
    [switch]$extractDB      = $false,
    [switch]$extractDBOnly  = $false,
    [hashtable]$extractDBTo = @{'chatdb' = '../pgsql/templates/dbtemplate_chatdb_all'},
    [string]$extractDBmapTo = '../pgsql/DBtemplateToDBmap.txt',
    [string]$runFlags       = '-dit --rm',
    [string]$container      = 'apachefiddle',
    [string]$image          = 'aphpchefiddle',
    [string]$netName        = 'fiddlenet',
    [string]$dbContainer    = 'aphpsql',
    [string]$dbImage        = 'postgresfiddle',
    [string]$dbDockerfile   = '../pgsql/',
    [string]$dbPort         = '5432',
    [string]$dbPassword     = 'password',
    [string]$dbConnecitonInfo   = "../private_request/psqlConnectionInfo.json"
)
$srcImage       = "php:8.0-apache";
$urllocation    = "http://localhost:8080";
$volumePrefix=@{
    'dest'='/var'
    'from'=(&{if(!$useIncovationPath) {$PSScriptRoot} else {$pwd.Path}})
};
#file structure help see -> https://alvinalexander.com/unix/edu/UnixSysAdmin/node169.shtml
$linkVolumes= 
    ("/htdocs","/var/www/html"),
    #("/conf/", "/var/conf/"),
    #("/icons","/var/www/htmlicons"),
    #("/images","/var/www/images"),
    #( "/request","/var/www/request"),
    ( "/private_request","/var/private_request")
    #("/logs/","/var/logs/"),
    #("/sbin/","/var/sbin/"),
    #("/cig-bin/","/var/cig-bin/")
;
$interactiveExpression_pgsql    = "start powershell {echo '$dbContainer';   docker exec -it $dbContainer    /bin/bash}";
$interactiveExpression_apache   = "start powershell {echo '$container';     docker exec -it $container      /bin/bash};"

push-location $volumePrefix['from'];

function quit{
    pop-location;
    exit;
}
function waitForContainerToStart([string]$containerName){
    # milliseconds
    $minSleep   = 50;
    $maxSleep   = 5000;
    $ratio      = 1.2;
    $interval   = 3;

    $tick   = $interval;
    $sleep  = $minSleep;

    while(!(docker ps --filter "name=$containerName" -q)){
        if($tick -eq 0){
            $sleep *= $ratio;
            if($sleep -ge $maxSleep){ $sleep = $maxSleep; $tick = -1;}
            else { $tick = $interval; }
        }else{
            $tick--;
        }
        $rand = Get-Random -Minimum .05 -Maximum 1.0
        [Console]::Beep(($sleep-$minSleep)/$maxSleep * 32000 + 732, $rand*$sleep); # audiable annoyance
        sleep -milliseconds ($sleep * (1-$rand));
    }
}
function waitForImageToAppear([string]$imageName){
    # milliseconds
    $minSleep   = 50;
    $maxSleep   = 5000;
    $ratio      = 1.2;
    $interval   = 3;

    $tick   = $interval;
    $sleep  = $minSleep;

    while(!(docker images -q $imageName)){
        if($tick -eq 0){
            $sleep *= $ratio;
            if($sleep -ge $maxSleep){ $sleep = $maxSleep; $tick = -1;}
            else { $tick = $interval; }
        }else{
            $tick--;
        }
        $rand = Get-Random -Minimum .05 -Maximum 1.0
        [Console]::Beep((1.0 - ($sleep-$minSleep)/$maxSleep) * 32000 + 732, $rand*$sleep); # audiable annoyance
        sleep -milliseconds ($sleep * (1-$rand));
    }
}
function rebuild-image($dockerfilePath, [string]$tag) {
    write-host "rebuilding image tag:$tag @ $dockerfilePath..." -ForegroundColor gray;
    docker image rm $tag; 
    docker build $dockerfilePath -t $tag;
}
function remove-container([string]$containerName) {
    write-host "removing container $containerName ... " -ForegroundColor gray -NoNewLine;
    $_contID = docker ps --filter "name=$containerName" -q
    
    if($_contID -ne $null){
        docker container stop $_contID;
    }else{
        write-host "no container found" -ForegroundColor gray;
    }
}
function start-pgsqlContainer{
    write-host "starting db container ... " -ForegroundColor gray -NoNewLine;
    if(!(docker ps --filter "name=$dbContainer" -aq)){
        if(!$rebuilddb) {write-host "failed to find db container. " -ForegroundColor gray -NoNewLine;}
        if(!(docker images $dbImage -q)){
            write-host "`n`tfailed to find db image. " -ForegroundColor yellow -NoNewLine;
            if((Read-Host -Prompt "rebuild db image? (y/n)") -eq 'y'){
                rebuild-image -dockerfilePath $dbDockerfile -tag $dbImage;
            }else{ return; }
        }

        write-host "`tstarting new db container:$dbContainer ..." -ForegroundColor gray;

        # for some raeson the run command fails if this isnt in a Invoke-Expression
        Invoke-Expression "docker run --name $dbContainer -p $($dbPort):5432 -e POSTGRES_PASSWORD=$dbPassword -d $dbImage;";

        waitForImageToAppear -imageName $dbImage;

        # build the templates
        docker exec $dbContainer bash -c "/setup/templateBuilder.sh";
    }else{
        docker start $dbContainer;
    }
}
function extract-psqlContent([hashtable]$outPaths = $extractDBTo, [string]$containerTag = $dbContainer) {
    write-host "extracting psql content container-tag:$containerTag ... " -ForegroundColor gray -NoNewLine;
    $_stp   = $false;
    $map    = '';

    if(!(docker ps --filter "name=$containerTag" -q)) { 
        if(!(docker ps --filter "name=$containerTag" -aq)) { 
            write-host "container not found." -ForegroundColor red;
            quit;
        }
  
        if(($extractDBOnly) -and ((Read-Host -Prompt "`ndb container found but is stopped. continue by start->extract->stop container? (y/n)") -eq 'y')){
            docker start $containerTag;
            $_stp = $true;
        }else {
            docker start $containerTag;
        }

        waitForContainerToStart $containerTag;
    }

    $tempFolder = "/extract_temp";
    docker exec $containerTag mkdir $tempFolder;

    $outPaths.GetEnumerator() | ForEach-Object {
        # make template
        $dbname         = $_.name;
        $fullContPth    = "$tempFolder/$dbname.tar";
        $fullHostPth    = "$($_.value).tar";

        write-host "`t$($containerTag):$fullContPth" -NoNewLine;
        docker exec $containerTag bash -c "pg_dump -U postgres $dbname > $fullContPth";

        write-host "`t==>`tlocalhost:$fullHostPth";
        docker cp $containerTag':'$fullContPth $fullHostPth;

        docker exec $containerTag rm $fullContPth;

        # update map
        $map += "$dbname,$fullContPth`n";
    }
    docker exec -d $containerTag rmdir $tempFolder;
    $map -replace ".$" #trim trailling char

    if($_stp){ docker stop $containerTag; }
    
    return $map;
}
function stop-container([string]$filter){
    write-host "stoping container(s), filter:$filter ... " -ForegroundColor gray;
    $_contID = docker ps --filter $filter -q;

    if($_contID){ docker stop $_contID; }
}

if($help) { 
    write-host 
    "   you got help! go read the code, its like 10 lines of actual code.
        [switches]
            -help       : show help txt
            -visit      : open the browser page if launch sucessful
            -showCommand: print docker command used
            -removeImage: deletes the image. will force to get a new one from docker. lazy way to update it
            -useInconvationPath : use the directory the command was called from
            -rebuild    : rebuilds image, stopping related running containers and removing the orgional image of the same name. does not remove containers
            -netName    : docker bridge network name with the db on it
            -dbContainer: name of existing db container
            -dbPort     : port to the db
        [text]
            -runFlags   : docker flags. --name=... and -p=... are already included. to change, edit this powershell script
            -container  : the container name
            -image      : the image name
        
        runFlags:   $runFlags
        container:  $container
        image:      $image
        srcImage:   $srcImage
        netName:    $netName
        dbContainer:    $dbContainer
        dbPort:     $dbPort
        
        [note]
            -docker daemon is not controlled by this script. it will not turn it on or off but will require it to be on for this script ot work
            -this is not intended to replace a Dockerfile, this is to set up shared volumes between the host and container so you can see changes faster.
            -configs not live even if the docker mount/volume is. try restarting services
            -containers wil remain o nnetwork even when disabled, docker will give duplicate end point error(ignore it if so)
            -if contianers/server is live but no content is displayed see the '-showCommand' option. mostlikely need to include '-useInvocationPath'";
    quit;
}
if($visitOnly)  {   Start-Process $urllocation;  quit; }
if($removeSrcImage){ docker image rm $srcImage; }
if($extractDB -or $extractDBOnly){
    $maptxt = (extract-psqlContent -outPaths $extractDBTo -containerTag $dbContainer);
    $maptxt | Set-content $extractDBmapTo;
    if($extractDBOnly) { quit; }
}
if($rebuild){ 
    remove-container -containerName $container;
    rebuild-image -dockerfilePath './' -tag $image; 
}
if($rebuilddb){
    if((docker ps --filter "name=$dbContainer" -aq)){
        if(!$extractDB -and (Read-Host -Prompt "rebuild db image without first extracting container data? (y/n)") -ne 'y'){ quit; }
        remove-container -containerName $dbContainer;
    }   

    rebuild-image -dockerfilePath $dbDockerfile -tag $dbImage;
}
if($stop) {   
    stop-container "name=$container|$dbContainer";   
    quit; 
}

#########################################
# psql
#########################################
# connection info updated when connected(see next section)
# starts container if it exists

start-pgsqlContainer;

#########################################
# apache
#########################################
$command = "docker run $runFlags --name $container -p 8080:80 ";

$linkVolumes | 
    %{ $command += "-v `"" + $volumePrefix['from'] + $_[0] + ":" + $_[1] + "`" "; }
$command += $image;

if($showCommand -or $showCommandOnly){
    echo "
        runFlags:   $runFlags
        container:  $container
        image:      $image
        command:
            $command `n";
    if($showCommandOnly) { quit; }
}

write-host "starting ws container ... " -ForegroundColor gray -NoNewLine;
if(docker ps --filter "name=$container" -aq){
    if((Read-Host -Prompt "container of the same name already exists. remove->restart? (y/n)") -eq 'y'){
        if(docker ps --filter "name=$container" -q){
            write-host "stopping existing ws container ... " -ForegroundColor gray -NoNewLine;
            docker stop $container;
            sleep -milliseconds 20;
        }
        if(docker ps --filter "name=$container" -aq){ docker rm $container; }

        Invoke-Expression $command;
    }
}else{ Invoke-Expression $command; }

if($visit)      {   Start-Process $urllocation; }

#########################################
# docker network
#########################################
# bridge , no limitations of any kind ... mmmm
# containers connected after creation
# connection info exported to private_request

if(!(docker network ls --filter "name=$netName" -q)){
    if((Read-Host -Prompt "network of name $netName cannot be found. create and continue? (y/n)") -eq 'y'){
        docker network create $netName --driver bridge;
    }else { quit; }
}

write-host "joining db & ws to network ..." -ForegroundColor gray;
$namedThings = docker network inspect fiddlenet | ?{$_ -match "Name"} | %{echo ($_.substring([Regex]::Match($_, '".*?"').groups[0].index + 9)).trim('",')}
if(-not $namedThings -contains $dbContainer){ docker network connect $netName $dbContainer; }
if(-not $namedThings -contains $conainer)   { docker network connect $netName $container; }

write-host "writing pgslq connection info to $dbConnecitonInfo ..." -ForegroundColor gray;
$dbiPv4 = (docker exec $dbContainer hostname -I).trim() -Split ' ',-1;
@{
    'iPv4'  =   $dbiPv4[-1]
    'port'  =   $dbPort
} | ConvertTo-Json | Set-Content $dbConnecitonInfo;

if($interactive){   waitForContainerToStart $dbContainer; Invoke-Expression $interactiveExpression_pgsql; }
if($interactive){   waitForContainerToStart $container; Invoke-Expression $interactiveExpression_apache;   }

quit;