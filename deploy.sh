#!/bin/bash

# remove storage link
rm -rf public/storage

# create storage link
php artisan storage:link

# cache
php artisan config:cache
php artisan route:cache
php artisan view:cache