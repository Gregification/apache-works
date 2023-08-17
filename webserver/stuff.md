### files
```
$/
├── etc
│   ├─ ports.conf
│   ├─ ports.conf
│   ├─ apache2.conf
│   ├── sites-avaliable
│   ├── sites-enabled
│   ├── conf-enabled
│   └── conf-avaliable
├── usr
│   └── local
│   *   └── php
│   *   *   ├─ php.ini
│   *   *   ├─ iccu65.dll
│   *   *   └── ext
│   *   *   *   └── php_pgsql.dll
├── var
│   ├── local
│   ├── private_request     | ./private_requests
│   └── www
│   *   └── html        | ./htdocs                      <------- web root
```
##### *key*
<font size=1>

- <code>[interanl folder] | [project src]</code>

</font>

### Commands
| context   | command       | description       |
| :---      | :---          | :---              |
| bash/php      | <code>php -ini </code> | php settings info. contains file locaitons. get php.ini locaiton with <code>php -ini \| grep php.ini </code> |
| bahs/php | ```php -m``` | list modules |

### Publish docker image
```
docker tag [src image id] [docker username]/[repo][:tag];
docker login -u "username" -p "password" docker.io;
docker push [full u just created];
```

```
docker tag (docker images -q | ?{$_ -like "eb*"})[0] georgebb/htmlfiddlepgsql:1
docker login -u "username" -p "password" docker.io;
docker push georgebb/htmlfiddle/pgsql:1
```

## Page 3
table ```Message```
| id SERIAL | timeDelivered | sentBy | message | 
| -- | -- | -- | -- |
| serial | TIMESTAMP | VARCHAR(255) | VARCHAR(940) |

```--drop table chat_templet;
--drop table "_chattemplate";
--create schema if not exists chats;
--create table if not exists chats._1 as table public._chattemplate; 
--alter table chats._1 add column id serial primary key;
--create table if not exists :tb as table :src;
--        alter table :tb add column id serial primary key;
--create table if not exists _chattemplate(timedelivered BIGINT primary key, "by" VARCHAR(255) not null, message VARCHAR(2000) not null);
--create table if not exists _users (username VARCHAR(255) PRIMARY KEY, creationtime BIGINT NOT NULL, lastactivetime BIGINT not NULL, description varchar(500));
--create table if not exists _images (id serial primary key, imgname varchar(512) not NULL, src varchar(255));
--create table if not exists _chats (title varchar(255) not NULL, usersonline int not NULL, lastactivetime bigint, creationtime bigint, id serial primary key, description varchar(2000));
--create table if not exists fiddle (word10 varchar(10) primary key);
--create table if not exists chats.test(varchar); 

--if not exists (select from pg_tables where schemaname=chats and tablename=_1) 
--	then
--    create table chats."_1" as table public."_chattemplate";
--	alter table chats."_1" add column id serial primary key;
--end if;

--insert into "user" values ('chat_templet occy', extract(epoch from now()), extract(epoch from now()));
--INSERT INTO public.chat1 (timedelivered, sentby, message) VALUES(now()::timestamp(0), '_direct', 'the message');
--insert into _users (username,creationtime,lastactivetime) values ('default name', extract(epoch from now()), extract(epoch from now()));
--insert into "_users" (username,creationtime,lastactivetime) select username,creationtime,lastactivetime from users;
--insert into "_chats" (title,creationtime,lastactivetime,usersonline,description) values ('chat',extract(epoch from now()),extract(epoch from now()),0,'') returning id;
--insert into fiddle (word10) values ('abcdefghijklmnopqrstuvwxyz'); --throws error if oversized
--insert into "_chattemplate" (timedelivered,"by",message) values (extract(epoch from now()), 'new chat', 'this is a filler message given on chat creation');
--insert into "_chats" (title,usersonline,creationtime,lastactivetime) values ('title',0,extract(epoch from now()),extract(epoch from now())) returning id;
--update _users set lastactivetime=-1 where username = 'default name';
--update _users set lastactivetime=extract(epoch from now()) where lastactivetime=-1;
--update _users set lastactivetime=-1 where not lastactivetime=-1;
--update _users set lastactivetime=lastactivetime-1 where username='cat';
--update "_users" set description = 'fart' where username = 'cat';
--alter table "_chattemplet" rename to _chattemplate;
--alter table "_chats" alter column id type serial primary key;
--alter table _chats add column id serial;

--create sequence 'id_seq' owned by chats._1.id;
--alter table chats."_1" alter column id set default nextval('id_seq');
--update chats._1 set id = nextval('id_seq');

--select lastactivetime from _user where username='meow';
--select * from _users where username='meow';
--select * from _users; 
--select id from "_chats" where title = 'default chat';
--select id from public."_chats" where title='moop';
--select exists (select 1 from _users where username='meow');
--select lastactivetime,username from _users where lastactivetime > 0 order by lastactivetime asc limit 1;
--select username from _users where lastactivetime > 0 order by username asc limit 10 offset 0;
--select (username,creationtime,lastactivetime,description) from "_users" where username like '%' order by username asc limit 10 offset 0;
--select count(*) from chats."_1" where timedelivered > 1686697100.4;
--select exists (select from pg_tables where schemaname='chats' and tablename='_1');
--select from pg_tables where schemaname='chats' and tablename='test';
--select timedelivered as td,"by",message as msg from chats."_1" order by timedelivered asc limit all offset 0;
--show search_path;

--drop database fiddler;
--drop table users;
--drop table _chats,"_chattemplet" ,"_images";
--delete from chats."_1" ;
```

---
```\\wsl$\docker-desktop-data\data\docker\containers\<containerid>```
---
## issues
- request/navbarPages.json chunky as associatative arrays. not necesassry either
- manually having to call ```sh /setup/templateBuilder.sh``` after rebuilding db container. calling it from docker-compose -> "command:","entrypoint:" and docker file -> "CMD"/"ENTRYPOINT" result in the same problem (henceforth refrenced as "CMD"), container crash. the psql db WILL NOT naturally start untill docker's "CMD" command has finished but that means the container has finished its task and will auto-delete itself. i have tried manually setting up the database through "CMD" but thats a mssive undertaking(wayy too much work to set up all the certificates,encription,ect) that effects all other containers that may connect to the db. i have tried to use the unix "at" and "crontab" commands to schedule the script to run in the future, after the container is up, but will still crash after they are declared. i have tried booting the webserver after the db container is up, then ssh-ing into it to remote execute the .sh file but the openssh-server does not start automatically and must be done though "CMD", resulting in the same problem as my first attempt. i give up