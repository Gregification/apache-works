FROM php:8.0-apache

# php           #######################
RUN a2dismod mpm_event
RUN a2enmod mpm_prefork \
    ssl \
    rewrite
RUN apt-get update
RUN apt-get install -y libpq-dev \
    postgresql-client
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql 
RUN apt-get clean

# apache config #######################
COPY ./other_configs/apache2.conf /etc/apache2/apache2.conf

# apache sites-enabled/vitural-host config
COPY ./other_configs/000-default.conf /etc/apache2/sites-available/000-default.conf

# php config    #######################
COPY ./other_configs/php/php.ini /usr/local/etc/php/php.ini

# src           #######################
WORKDIR /var/
COPY ./private_request ./private_request
COPY ./htdocs ./www/html

EXPOSE 80

WORKDIR /var/www
#docker run --name="aphpchefiddle" --memory="2g" -dit -p 8080:80 --cpus="1.5" aphpche