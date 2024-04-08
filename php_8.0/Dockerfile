# FROM php:8.0-apache

# ENV COMPOSER_ALLOW_SUPERUSER=1

# EXPOSE 80
# WORKDIR /app

# # git, unzip & zip are for composer
# RUN apt-get update -qq && \
#     apt-get install -qy \
#     git \
#     gnupg \
#     unzip \
#     zip && \
#     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
#     apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# # PHP Extensions
# RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
# COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

# # Apache
# COPY errors /errors
# COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
# COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf
# COPY index.php /app/index.php

# RUN a2enmod rewrite remoteip && \
#     a2enconf z-app

#######

FROM php:8.0-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev;

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar dom mbstring zip gd xsl
RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /var/www/