#!/bin/bash

_PGUser=postgres
PGPASSWORD=$(< ./kittycatdancedancednace.txt)
dbMapFile=./DBtemplateToDBmap.txt

while IFS=, read -r dbname tmpltpth; do 
    echo "dbname $dbname, template path $tmpltpth";
    createdb -U $_PGUser $dbname
    pg_restore -U postgres $dbname $tmpltpth
  done < $dbMapFile

# rm ./kittycatdancedancednace.txt