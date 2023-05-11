#php version not secured. cant find a list of image versions so it stays as such
FROM php:7.2-apache

WORKDIR /var/www/
COPY ./htdocs/ ./html/
COPY ./images/ ./images/
COPY ./icons/ ./icons/
COPY ./other_configs/apache2.conf /etc/apache2/apache2.conf

#most of this is redundent but catches older versions
RUN a2dismod mpm_event
RUN a2enmod mpm_prefork
RUN a2enmod php7
RUN service apache2 restart

EXPOSE 80

#docker run --name="aphpchefiddle" --memory="2g" -dit -p 8080:80 --cpus="1.5" aphpche