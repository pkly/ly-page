#!/bin/bash

/usr/sbin/crond &
nginx &
su -c '/var/www/postgres.sh' postgres
php-fpm