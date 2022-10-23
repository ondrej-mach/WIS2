#!/bin/sh

# $1 = username
# $2 = password

export MYSQL_PWD=$2
TABLES=$(mysql $1 -e 'SHOW TABLES' | awk '{ print $1}' | grep -v '^Tables' )

for t in $TABLES
do
        echo "Dropping table $t"
        mysql $1 -e "SET FOREIGN_KEY_CHECKS = 0; DROP TABLE $t"
done

echo "Setting to UTF8"
mysql $1 -e "ALTER DATABASE $1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo "Initializing database"
mysql $1 < init_db.sql

echo "Inserting demo data"
mysql $1 < insert_data.sql

echo "Cleaning up"
rm -f init_db.sql insert_data.sql
