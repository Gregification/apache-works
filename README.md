# Html Fiddle 
a Laravel project running out of apache through docker. is not criticaly dependent on external services. <br>

images used 
 - php:8.0-apache
 - postgres:15
 - adminer:4.8.1-standalone

frameworks
 - Apache
 - Bootstrap
 - Laravel

--- 

## How to visit
ocassionaly avaliable at [47.37.113.251:8080](http://47.37.113.251:8080) . otherwise you can host it yourself.<br>

# To host it yourself 
> *note : the powershell scriptes are only to help automate docker commands. they are not necessary* <br>

### USING DOCKER-COMPOSE
 1. build & run the project with ```docker compose up -d --build```
 1. visit <a href="http://localhost:8080">localhost:8080</a>
---

#### todo
- caching with <a href="https://httpd.apache.org/docs/2.4/caching.html#:~:text=The%20Apache%20HTTP%20server%20offers,the%20server%20in%20various%20ways.&text=mod_cache%20and%20its%20provider%20modules,intelligent%2C%20HTTP%2Daware%20caching." alt="mod_cach apache modules">mod_cach apache modules</a> or nginx