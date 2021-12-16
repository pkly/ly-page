#!/bin/bash

/usr/sbin/crond &
nginx &
php-fpm