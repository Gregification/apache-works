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