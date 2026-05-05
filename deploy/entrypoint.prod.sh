#!/usr/bin/env bash
set -e

mkdir -p \
  /var/www/html/core/storage/framework/cache/data \
  /var/www/html/core/storage/framework/sessions \
  /var/www/html/core/storage/framework/views \
  /var/www/html/core/storage/logs \
  /var/www/html/core/bootstrap/cache

chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache

cd /var/www/html/core

php artisan package:discover --ansi
php artisan config:cache
php artisan view:cache

exec "$@"
