FROM postgres:15-alpine

ENV LANG en_US.utf8

#see txt.md or documentation for context (innitiliaztion scripts).
# RUN localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8

COPY ./init-db /docker-entrypoint-initdb.d

#set templates
WORKDIR /setup
ADD templates ./templates/
COPY DBtemplateToDBmap.txt .
COPY templateBuilder.sh .
# FROM postgres
# RUN rm /usr/local/bin/docker-entrypoint.sh
# COPY kittycatdancedancednace.txt .

EXPOSE 5432

WORKDIR /