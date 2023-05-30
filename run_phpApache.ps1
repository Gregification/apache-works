#! /usr/bin/pwsh
#image -> php:7.2-apache
#note: this basically ignore source material from the dockerfile, update the linked volumes for folder changes

param (
    [switch]$visit = $false,
    [switch]$visitOnly = $false,
    [switch]$stop = $false,
    [switch]$showCommand = $false,
    [switch]$help = $false,
    [switch]$removeSrcImage = $false,
    [switch]$showCommandOnly = $false,
    [switch]$useIncovationPath = $false,
    [switch]$interactive = $false,
    [switch]$rebuild = $false,
    [string]$runFlags = '-dit --rm',
    [string]$container = 'apachefiddle',
    [string]$image = 'aphpchefiddle',
    [string]$netName = 'fiddlenet',
    [string]$dbContainer = 'aphpsql',
    [string]$dbPort = '5432',
    [string]$dbConnecitonInfo = "./private_request/psqlConnectionInfo.json"
)
$srcImage = "php:7.2-apache";

if($help) { 
    write-host 
    "   you got help! go read the code, its like 10 lines of actual code.
        [switches]
            -help       : show help txt
            -visit      : open the browser page if launch sucessful
            -visitOnly  : just open the browser page, nothing more
            -showCommand: print docker command used
            -removeImage: deletes the image. will force to get a new one from docker. lazy way to update it
            -useInconvationPath : use the directory the command was called from
            -rebuild    : rebuilds image, stopping related running containers and removing the orgional image of the same name. does not remove containers
            -netName    : docker bridge network name with the db on it
            -dbContainer: name of existing db container
            -dbPort     : port to the db
        [text]
            -runFlags   : docker flags. --name=... and -p=... are already included => edit this file to change
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
            -containers wil remain o nnetwork even when disabled, docker will give duplicate end point error(ignore it if so)";
    return;
}
if($visitOnly)  {   Start-Process "http://localhost:8080";  return; }


#########################################
# apache
#########################################

if($removeSrcImage){    docker image rm $srcImage }
if($rebuild){   
    $old = docker ps --filter "name=$container" -q
    if($old -ne $null){
        docker container stop $old;
    }
    docker image rm $image; 
    docker build $PSScriptRoot/ -t $image;
}
if($stop)       {   docker stop $container $dbContainer;   return; }

#file structure help see -> https://alvinalexander.com/unix/edu/UnixSysAdmin/node169.shtml
$volumePrefix=@{
    'dest'='/var'
    'from'=(&{if($useIncovationPath) {$PSScriptRoot} else {$pwd.Path}})
};
########## MANUALY UPDATE DURING DEV . will error if not
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
$interactiveExpression = "start powershell {echo '$container';docker exec -it $container /bin/bash}; start powershell {echo '$dbContainer'; docker exec -it $dbContainer /bin/bash}";
<#
$linkMounts=@(
    #("/other_configs/httpd.conf","/etc/apache2/httpd.conf")
    ("/other_configs/apache2.conf","/etc/apache2/apache2.conf"),
    ('','')
);
$linkMounts | %{echo "$_[0] `n`t $_[1]"}
#>
#docker run -dit --rm --name htmlfiddle -p 8080:80 -v D:\vsc\htmlfiddle/public-html/:/usr/local/apache2/htdocs/ httpd:2.4

$command = "docker run $runFlags --name $container -p 8080:80 ";
$linkVolumes | %{ $command += "-v `"" + $volumePrefix['from'] + $_[0] + ":" + $_[1] + "`" "; }
#$linkMounts | ?{$_[0].length -ne 0} | %{ $command += "--mount type=bind,source=`"" + $volumePrefix['from'] + $_[0] + "`",target=`"" + $_[1] + "`" "}
$command += $image;
if($showCommand -or $showCommandOnly){
    echo "
        runFlags:   $runFlags
        container:  $container
        image:      $image
        command:
            $command `n";
    if($showCommandOnly) { return; }
}

$old = docker ps --filter "name=$container" -aq
if($old -ne $null){
    if((Read-Host -Prompt "container of same name alraedy exists. remove and restart? (y/n)") -eq 'y'){
        write-host "stopping existing docker container..." -ForegroundColor Yellow -NoNewLine;
        docker stop $old;
        docker rm $old;
        Invoke-Expression $command;
    }else{ 
        if($interactive){   Invoke-Expression $interactiveExpression;   }
        return; 
    }
}else{Invoke-Expression $command;}

$old = docker ps --filter "name=$container" -q
if($old -ne $null){ 
    write-host "APACHE:$container" -BackgroundColor Green 
    if($interactive){   Invoke-Expression $interactiveExpression; }
    if($visit)      {   sleep -Milliseconds 200;   Start-Process "http://localhost:8080";  }
}else{ 
    write-host "FAILED TO START APACHE:$container" -BackgroundColor Red -NoNewline;
    return;
}



#########################################
# psql
#########################################
# connection info updated when connected(see next section)
$old = docker ps --filter "name=$dbContainer" -q;
if($old -eq $null){
    $old = docker ps --filter "name=$dbContainer" -aq;
    if($old -eq $null){ write-host "FAILED TO FIND DB CONTAINER." -BackgroundColor Red; return; }
    else {  docker start $dbContainer;  }
}


#########################################
# docker netowrk
#########################################
# bridge , no limitations of any kind ... mmmm
# containers connected after creation
# connection info updated

$old = docker network ls --filter "name=$netName" -q;
if($old -eq $null){
    if((Read-Host -Prompt "network of name $netName cannot be found. create and continue? (y/n)") -eq 'y'){
        docker network create $netName --driver bridge;
    }else { return; }
}

docker network connect $netName $dbContainer;
docker network connect $netName $container;

$dbiPv4 = (docker exec $dbContainer hostname -I).trim() -Split ' ',-1;
@{
    'iPv4'  =   $dbiPv4[-1]
    'port'  =   $dbPort
} | ConvertTo-Json | Set-Content $dbConnecitonInfo;