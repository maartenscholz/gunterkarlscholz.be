FROM php:7.4.0-fpm

MAINTAINER Maarten Scholz

RUN apt-get update && apt-get install -y libicu-dev git libzip-dev libpng-dev libjpeg62-turbo-dev
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install intl bcmath zip gd exif pdo pdo_mysql
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
