FROM php:8.2-fpm

#ARG NEW_RELIC_LICENSE_KEY
#ENV NEW_RELIC_APPNAME=CartService-Laravel

RUN apt-get update && apt-get install -y \
    gnupg lsb-release wget curl unzip libpq-dev libzip-dev zip libonig-dev libxml2-dev git \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && pecl install xdebug && docker-php-ext-enable xdebug

RUN wget -O - https://download.newrelic.com/548C16BF.gpg | gpg --dearmor -o /usr/share/keyrings/newrelic-archive-keyring.gpg \
  && echo "deb [signed-by=/usr/share/keyrings/newrelic-archive-keyring.gpg] https://download.newrelic.com/debian/ newrelic non-free" | tee /etc/apt/sources.list.d/newrelic.list \
  && apt-get update && apt-get install -y newrelic-php5 \
  && NR_INSTALL_SILENT=1 newrelic-install install

RUN git config --global --add safe.directory /var/www
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chmod -R 775 storage bootstrap/cache
