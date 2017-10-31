FROM php:fpm

MAINTAINER Maarten Scholz

RUN apt-get update && apt-get install -y libicu-dev git zlib1g-dev
RUN docker-php-ext-install intl && docker-php-ext-install bcmath && docker-php-ext-install zip
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
