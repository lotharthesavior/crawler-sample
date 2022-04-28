#!/bin/bash

chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

php-fpm8.1 -F -R