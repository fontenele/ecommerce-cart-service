FROM php:8.2-fpm

ARG NEW_RELIC_LICENSE_KEY
ENV NEW_RELIC_APPNAME=CartService-Laravel

RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev zip \
    libonig-dev libxml2-dev procps \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install newrelic \
    && echo "extension=newrelic.so" > /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.license=${NEW_RELIC_LICENSE_KEY}" >> /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.appname=${NEW_RELIC_APPNAME}" >> /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.distributed_tracing_enabled=true" >> /usr/local/etc/php/conf.d/newrelic.ini

RUN git config --global --add safe.directory /var/www
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www \
    && chmod -R ug+rw storage bootstrap/cache
