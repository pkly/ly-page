#!/bin/sh

set -m

/usr/sbin/crond &
nginx -g deamon on;

php-fpm