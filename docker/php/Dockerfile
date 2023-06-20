FROM php:8.2-fpm

ARG DEPS="bash vim git wget npm"
RUN apt-get update && apt-get install -y $DEPS

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN apt-get -y install cron

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip
    
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php 
RUN php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN pecl install uopz && \
    docker-php-ext-enable uopz


WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www