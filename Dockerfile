FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev zip \
    libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && pecl install xdebug && docker-php-ext-enable xdebug

RUN git config --global --add safe.directory /var/www
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www
