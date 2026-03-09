FROM php:8.1-fpm

COPY docker/php/php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update
WORKDIR /var/www

COPY . /var/www

WORKDIR /var/www/src


RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage bootstrap/cache

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}