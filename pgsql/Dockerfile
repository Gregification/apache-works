####################
### base dockerfile
####################

FROM postgres:15

ENV LANG en_US.utf8

ENV POSTGRES_PASSWORD "password"
ENV POSTGRES_INITDB_ARGS "--locale-provider=icu --icu-locale=en-US"

#see txt.md or documentation for context (innitiliaztion scripts).
RUN localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8

#set templates
WORKDIR /temp
COPY ./dbtemplate_chatdb.pgsql .

EXPOSE 5432

# RUN echo 'create database chatdb' | psql -U postgres
# RUN psql -U postgres chatdb < ./dbtemplate_chatdb.pgsql


# set optional templates, file name (excluding extension) must match db name
# WORKDIR /temp/
# ARG dbtemplates 
# RUN for i in $dbtemplates; do \
#     COPY ./templates/$i.pgsql ./$i.pgsql; \
#     RUN psql -U postgres $i < $i.pgsql; \
#     RUN rm -rf ./*; \
#     RUN echo 'template: $i' >> /dbtempbuildlog.txt; \
#     done;
# WORKDIR /;