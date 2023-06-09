# Html Fiddle 
a apache webserver ran out of docker. is not criticaly dependent on external services. <br>

images used 
 - php:7.4-apache
 - postgres:15

frameworks
 - apache
 - bootstrap

--- 

## How to visit
ocassionaly avaliable at [47.37.113.251:8080](http://47.37.113.251:8080) . otherwise you can host it yourself.<br>

## To host it yourself 
> *note : the powershell scriptes are only to help automate docker commands. they are not necessary* <br>

WINDOWS
1. install Docker & clone this repo. turn on the docker daemon.
1. create a ```postgres:15``` container (ex: name->_testdb_ , port->_5432_)
1. inside the new db, create a few tables with. or see. *ALTERNATIVE-- listed bellow steps* 
    ```
    create table if not exists _chattemplet (timeDelivered_u BIGINT PRIMARY KEY,  id serial,  sentBy VARCHAR(255),    message VARCHAR(940) NOT NULL);
    create table if not exists _users       (username VARCHAR(255)  PRIMARY KEY,    creationtime BIGINT not null,    lastactivetime BIGINT not null);
    create table if not exists _images      (id serial primary key, imgname varchar(512) NOT NULL,   img bytea);
    create table if not exists _chats       (title varchar(255) NOT NULL,    usersonline int NOT NULL,    lastactivetime bigint NOT NULL);
    ```
1. navigate to the folder containing [run_phpApache.ps1](https://github.com/Gregification/htmlfiddle/blob/main/run_phpApache.ps1) , note: adding the ```-useIncovationPath``` flag to the command lets it be called from any locaiton.
1. for the initial startup run ```.\run_phpApache.ps1 -rebuild -visit``` , afterwards just ```.\run_phpApache.ps1``` will work.
    - ```.\run_phpApache.ps1 -help``` for help or see the param fields of [the script](https://github.com/Gregification/htmlfiddle/blob/main/run_phpApache.ps1) (starts line 5).<br>
1. check that [private_request/config.php](https://github.com/Gregification/htmlfiddle/blob/main/private_request/config.php)(generated when ```.\run_phpApache.ps1``` is ran) has the correct information for the psql db. the file [psqlConnecitonInfo.json](https://github.com/Gregification/htmlfiddle/blob/main/private_request/psqlConnectionInfo.json) is needed, its generated by the powershell script. it supplies the psql db's port & ip inside the docker network.


- to quit run ```.\run_phpApache.ps1 -stop``` or stop the containers manualy
- ALTERNATIVE pgsql setup: the ```pgsql_dirty.tar``` file ([stored in a google drive since too large(.7gb) for casual upload](https://drive.google.com/drive/folders/1m2hxDKJHhBzIbTAJeKPh1kAFdB16_mnZ?usp=sharing)) is a .tar of a working postgresql db container saved as a iamge, then a container. use docker to create a image then container with it and make sure the name matches whats in the ```[string]$dbContainer = 'aphpsql'``` paramater in the powershell launch script aka. [run_phpApache.ps1 : around line#20](https://github.com/Gregification/htmlfiddle/blob/main/run_phpApache.ps1)
---
<!-- ## noteable
- there is no api. its just a bunch of POST calls back and forth. planning to switch over to one eventually -->
<p align="right"><img src="https://raw.githubusercontent.com/Gregification/htmlfiddle/main/htdocs/favicon.ico"></p>
