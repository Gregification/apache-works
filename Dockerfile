#php version not secured. cant find a list of image versions so it stays as such
FROM php:7.2-apache

# php stupidity #######################
RUN a2dismod mpm_event
RUN a2enmod mpm_prefork \
    php7

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    sqlite3 \
    php7.2-pgsql
RUN rm -rf /var/lib/apt/lists/* 
RUN docker-php-ext-install \
    intl \
    pdo_pgsql \
    pdo \
    pgsql \
    pdo_sqlite

RUN service apache2 restart

# apache config #######################
ADD ./other_configs/apache2.conf /etc/apache2/apache2.conf

# php config ##########################
ADD ./other_configs/php/php.ini /usr/local/etc/php/php.ini

# src #################################
#WORKDIR /var/www/
#COPY ./htdocs/ ./html/
#ADD ./images/ ./images/
#ADD ./icons/ ./icons/

EXPOSE 80

#docker run --name="aphpchefiddle" --memory="2g" -dit -p 8080:80 --cpus="1.5" aphpche