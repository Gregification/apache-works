#! /usr/bin/pwsh
#image -> php:7.2-apache

param (
    [switch]$visit = $false,
    [switch]$visitOnly = $false,
    [switch]$stop = $false,
    [switch]$showCommand = $false,
    [switch]$help = $false,
    [switch]$removeImage = $false,
    [switch]$showCommandOnly = $false,
    [string]$runFlags = '-dit --rm',
    [string]$container = 'phpapachefiddle',
    [string]$image = 'php:7.2-apache'
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
            -runFlags   : docker flags. --name=... and -p=... are already included => edit this file to change
            -container  : the container name
            -image      : the image name
        
        runFlags:   $runFlags
        container:  $container
        image:      $image
        
        [note]
            -docker daemon is not controlled by this script. it will not turn it on or off but will require it to be on for this script ot work
            -this is not intended to replace a Dockerfile, this is to set up shared vlumes between the host and container so you can see changes faster.
            -configs not live even if the docker mount/volume is. try restarting services";
    return;
}
if($visitOnly)  {   Start-Process "http://localhost:8080";  return; }
if($removeImage){   docker image remove ($image);   }
if($stop)       {   docker stop ($container);   return; }

#file structure help see -> https://alvinalexander.com/unix/edu/UnixSysAdmin/node169.shtml
$volumePrefix=@{
    'dest'='/var'
    'from'=$PWD.Path
};
$linkVolumes= 
    ("/htdocs/","/www/html/"),
    #("/conf/", "/conf/"),
    ("/icons/","/www/html/icons/"),
    ("/images/","/www/html/images/"),
    ("/requests/","/www/html/requests/")
    #("/logs/","/logs/"),
    #("/sbin/","/sbin/"),
    #("/cig-bin/","/cig-bin/")
;
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
$linkVolumes | %{ $command += "-v `"" + $volumePrefix['from'] + $_[0] + ":" + $volumePrefix['dest'] + $_[1] + "`" "; }
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
        docker rm $old;
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