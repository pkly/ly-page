#!/bin/sh

set -m

php-fpm &
nginx -g deamon on;

/sbin/tini -- /usr/sbin/crond -f