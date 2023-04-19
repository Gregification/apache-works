#see https://alvinalexander.com/unix/edu/UnixSysAdmin/node169.shtml
param (
    [switch]$visit = $false,
    [switch]$visitOnly = $false,
    [switch]$stop = $false,
    [switch]$showCommand = $false,
    [switch]$help = $false,
    [switch]$removeImage = $false,
    [string]$runFlags = '-dit --rm',
    [string]$container = 'apachefiddle',
    [string]$image = 'httpd:2.4'
)

if($help) { 
    write-host 
    "   you got help! go read the code, its like 10 lines of actual code.
        [switches]
            -help       : show help txt
            -visit      : open the browser page if launch sucessful
            -visitOnly  : just open the browser page, nothing more
            -showCommand: print docker command used
            -removeImage: deletes the image. will force to get a new one from docker. lazy way to update it
        [text]
            -runFlags   : docker flags. --name=... and -p=... are already included => edit through file
            -container  : the container name
            -image      : the image name
        
        runFlags:   $runFlags
        container:  $container
        image:      $image
        
        [note]
            -docker daemon is not controlled by this script. it will not turn it on or off but will require it to be on for this script ot work
            -from george b. 4/18/2023
            ";
    return;
}
if($visitOnly)  {   Start-Process "http://localhost:8080";  return; }
if($removeImage){   docker image remove ($image);   }
if($stop)       {   docker stop ($container);   return; }

$volumePrefix=@{
    'dest'='/usr/local/apache2'
    'from'=$PWD.Path
};

$linkVolumes= 
    ("/htdocs/","/htdocs/"),
    #("/conf/", "/conf/"), #emptying hte config may screw up things
    ("/icons/","/icons/"),
    ("/images/","/images/"),
    ("/logs/","/logs/")
    #("/sbin/","/sbin/"),
    #("/cig-bin/","/cig-bin/")
;

#docker run -dit --rm --name htmlfiddle -p 8080:80 -v D:\vsc\htmlfiddle/public-html/:/usr/local/apache2/htdocs/ httpd:2.4

$command = "docker run $runFlags --name $container -p 8080:80 ";
$linkVolumes | %{ $command += "-v " + $volumePrefix['from'] + $_[0] + ':' + $volumePrefix['dest'] + $_[1] + ' '; }
$command += 'httpd:2.4;';
if($showCommand){
    echo "
        runFlags:   $runFlags
        container:  $container
        image:      $image
        command:
            $command";
}

$old = docker ps --filter "name=$container" -aq
if($old -ne $null){
    if((Read-Host -Prompt "container of same name alraedy exists. removeand restart? (y/n)") -eq 'y'){
        write-host "stopping existing docker container..." -ForegroundColor Yellow -NoNewLine;
        docker stop $old;
        Invoke-Expression $command;
    }else{ return; }
}else{Invoke-Expression $command;}

$old = docker ps --filter "name=$container" -q
if($old -ne $null){ 
    write-host "CONTAINER $container UP" -BackgroundColor Green 
    if($visit)      {   Start-Process "http://localhost:8080";  }
}else{ 
    write-host "FAILED TO START CONTAINER." -BackgroundColor Red;
}