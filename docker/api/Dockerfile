FROM php:8.1-fpm

WORKDIR /var/www/laravel-app

RUN apt-get update && \
	apt-get install -y git unzip libzip-dev libicu-dev libonig-dev && \
	docker-php-ext-install intl pdo_mysql zip bcmath && \
	pecl install xdebug && \
	docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
