#!/bin/bash

/usr/sbin/crond &
nginx &
echo "Waiting for 5 seconds for database to get up"
bash "/var/www/scripts/install.sh"
php-fpm