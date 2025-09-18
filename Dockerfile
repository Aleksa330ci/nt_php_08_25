FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
 && docker-php-ext-install pdo pdo_mysql opcache \
 && a2enmod rewrite headers expires \
 && rm -rf /var/lib/apt/lists/*

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 80
