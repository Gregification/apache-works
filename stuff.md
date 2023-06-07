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

### commands
| context   | command       | description       |
| :---      | :---          | :---              |
| bash/php      | <code>php -ini </code> | php settings info. contains file locaitons. get php.ini locaiton with <code>php -ini \| grep php.ini </code> |
| bahs/php | ```php -m``` | list modules |

## Page 3
table ```Message```
| id SERIAL | timeDelivered | sentBy | message | 
| -- | -- | -- | -- |
| serial | TIMESTAMP | VARCHAR(255) | VARCHAR(940) |

```
--drop table chat_templet;
--create table chat_1 as table chat_templet with no data;  
--create table if not exists _chattemplet(timeDelivered_u BIGINT not NULL, title VARCHAR(255) primary key, sentBy VARCHAR(255), message VARCHAR(940) not NULL);
--create table if not exists _users (username VARCHAR(255) PRIMARY KEY, creationtime BIGINT NOT NULL, lastactivetime BIGINT not NULL);
--create table if not exists _images (id serial primary key, imgname varchar(512) not NULL, img bytea);
--create table if not exists _chats (title varchar(255) not NULL, usersonline int not NULL, lastactivetime bigint);
--create table if not exists fiddle (word10 varchar(10) primary key);

--insert into "user" values ('chat_templet occy', extract(epoch from now()), extract(epoch from now()));
--INSERT INTO public.chat1 (timedelivered, sentby, message) VALUES(now()::timestamp(0), '_direct', 'the message');
--insert into _users (username,creationtime,lastactivetime) values ('default name', extract(epoch from now()), extract(epoch from now()));
--insert into "_users" (username,creationtime,lastactivetime) select username,creationtime,lastactivetime from users;
--insert into "_chats" (title,creationtime,lastactivetime,usersonline,description) values ('chat',extract(epoch from now()),extract(epoch from now()),0,'describe soemthing like a cat meow mewo meow');
--insert into fiddle (word10) values ('abcdefghijklmnopqrstuvwxyz'); --throws error if oversized
--update _users set lastactivetime=-1 where username = 'default name';
--update _users set lastactivetime=extract(epoch from now()) where lastactivetime=-1;
--update _users set lastactivetime=-1 where not lastactivetime=-1;
--update _users set lastactivetime=extract(epoch from now()) where username similar to 'asdas%';
--alter table _users rename to users;
--alter table "_chats" alter column description type varchar(1500);
--alter table _chats add column creationtime bigint;
--select lastactivetime from _user where username='meow';
--select * from _users where username='meow';
--select * from _users; 
--select exists (select 1 from _users where username='meow');
--select lastactivetime,username from _users where lastactivetime > 0 order by lastactivetime asc limit 1;
--select username from _users where lastactivetime > 0 order by username asc limit 10 offset 0;
--select (username,creationtime,lastactivetime,description) from "_users" where username like '%' order by username asc limit 10 offset 0;
--select count(*) from "_users" where username like '%';

--drop database fiddler;
--drop table users;
--drop table _chats,"_chattemplet" ,"_images";
--delete from "_users" where username like '%husb%';
```

---
## issues
- request/navbarPages.json chunky as associatative arrays. not necesassry either
