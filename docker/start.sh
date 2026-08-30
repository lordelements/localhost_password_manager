#!/bin/sh
set -e

cd /var/www/html

# Render's filesystem is ephemeral on the Free plan. Create the SQLite DB
# when the container starts and rebuild its schema from Laravel migrations.
mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

chown -R www-data:www-data database storage bootstrap/cache
chmod 664 database/database.sqlite

# Recreate the public storage symlink if needed.
php artisan storage:link --force || true

# Run migrations and cache Laravel for production.
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan config:clear
php artisan cache:clear

# Start PHP-FPM in the background, then keep Nginx in the foreground.
php-fpm -D
exec nginx -g 'daemon off;'
