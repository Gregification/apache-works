FROM postgres:15

ENV LANG en_US.utf8
ENV POSTGRES_USER "postgres"
ENV POSTGRES_PASSWORD "password"
ENV POSTGRES_INITDB_ARGS "--locale-provider=icu --icu-locale=en-US"

#see txt.md or documentation for context (innitiliaztion scripts).
RUN localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8

#set templates
WORKDIR /setup
ADD templates ./templates/
COPY templateBuilder.sh .
COPY kittycatdancedancednace.txt .
COPY DBtemplateToDBmap.txt .

EXPOSE 5432

WORKDIR /