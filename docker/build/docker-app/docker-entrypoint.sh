#!/bin/bash

/usr/sbin/crond &
nginx &
echo "Waiting for 15 seconds for database to get up"
sleep 15
bash "/var/www/scripts/install.sh"
php-fpm