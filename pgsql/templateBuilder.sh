#!/bin/bash

_PGUser=postgres
dbMapFile=/setup/DBtemplateToDBmap.txt

_passwordsrc=/setup/kittycatdancedancednace.txt
PGPASSWORD=$(< $_passwordsrc)

echo -n "waiting for postgresql to start ... ";
while ! pg_isready -q -U $_PGUser; do 
    echo 'psql is not ready'
    sleep 1;
  done

echo "writing templates ...";

while IFS=, read -r dbname tmpltpth; do 
    echo "    $dbname < $tmpltpth";
    createdb -U $_PGUser $dbname
    pg_restore -U postgres -d $dbname $tmpltpth
  done < $dbMapFile

echo "done writing templates";
echo "template builder was ran." > /message.t

rm -rf /setup;