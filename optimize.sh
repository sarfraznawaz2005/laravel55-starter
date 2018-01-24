#!/bin/sh
php artisan clear-compiled;
php artisan cache:clear;
php artisan view:clear;
php artisan config:clear;
php artisan optimize --force;
php artisan app:cleanup;
#echo Press Enter...
#read