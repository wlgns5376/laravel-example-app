FROM renokico/laravel-base:latest-8.0-fpm-alpine

ENV APP_HOME /var/www/html

WORKDIR ${APP_HOME}

COPY . ${APP_HOME}

RUN chown -R www-data:www-data storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# Install NPM dependencies
RUN rm -rf package-lock.json \
        && npm install \
        && npm run prod \
        && rm -rf node_modules

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"