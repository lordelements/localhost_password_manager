# Laravel 12 + PHP 8.3 + Nginx + Vite
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts
COPY . .
RUN composer dump-autoload --no-dev --optimize

FROM node:22-bookworm-slim AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN npm run build

FROM php:8.3-fpm-bookworm AS app
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        sqlite3 \
        libsqlite3-dev \
        libonig-dev \
    && docker-php-ext-install pdo_sqlite mbstring bcmath exif pcntl \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir -p /run/php /var/log/nginx

COPY --from=vendor /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache database \
    && chown -R www-data:www-data storage bootstrap/cache database

RUN php artisan config:clear

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]

