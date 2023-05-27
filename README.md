### visit at 47.37.113.251:8080
- the dockerfile is for the php supporting version only. use <code>run_httpd.ps1</code> for the old version
- <code>run_phpApache.ps1</code> launches container but fails to update the containers services. use the dockerfile

## dev things
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

---
## issues
- request/navbarPages.json chunky as associatative arrays. not necesassry either
