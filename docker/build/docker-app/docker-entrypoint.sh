#!/bin/sh

set -m

/usr/sbin/crond &
nginx &

php-fpm