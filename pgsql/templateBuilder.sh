#!/bin/bash
_PGUser=postgres
dbMapFile=/setup/DBtemplateToDBmap.txt

_passwordsrc=/setup/kittycatdancedancednace.txt
PGPASSWORD=$(< $_passwordsrc)

echo -n "waiting for postgresql to start ... ";
sleep 5;
echo "writing templates ...";

while IFS=, read -r dbname tmpltpth; do 
    echo "    $dbname < $tmpltpth";
    createdb -U $_PGUser $dbname
    pg_restore -U postgres -d $dbname $tmpltpth
  done < $dbMapFile

echo "done writing templates.";
rm $_passwordsrc;