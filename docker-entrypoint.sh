#!/bin/sh

php artisan package:discover --ansi
php-fpm -D
nginx -g 'daemon off;'
