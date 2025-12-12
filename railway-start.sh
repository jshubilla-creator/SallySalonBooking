#!/bin/bash
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan storage:link
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8080
