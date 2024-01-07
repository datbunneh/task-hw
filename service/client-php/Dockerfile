FROM php:8-fpm

#install applications
RUN apt-get -y update
RUN apt-get -y install zip
RUN apt-get -y install libzip-dev
RUN apt-get -y install libicu-dev
RUN apt-get -y install libpq-dev

#install php extensions
RUN docker-php-ext-install opcache
RUN docker-php-ext-install intl
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install bcmath
RUN pecl install apcu

#install dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#fix terminal wrapping
COPY service/common/etc/.bashrc /tmp/
RUN cat /tmp/.bashrc >> /root/.bashrc

#prepare php
RUN cp ${PHP_INI_DIR}/php.ini-development ${PHP_INI_DIR}/php.ini
COPY service/client-php/etc/ ${PHP_INI_DIR}/conf.d/
RUN mkdir -m 777 -p /var/php/session
RUN mkdir -m 777 -p /var/log/php
