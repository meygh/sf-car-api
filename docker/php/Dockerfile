FROM php:8.1-fpm
ARG TIMEZONE
WORKDIR /var/www

#COPY wait-for-it.sh /usr/bin/wait-for-it
#RUN chmod +x /usr/bin/wait-for-it

COPY config/php.ini /usr/local/etc/php/conf.d/php.ini
#COPY config/php-cli.ini /usr/local/etc/php/conf.d/php-cli.ini
COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update && apt-get install -y \
    vim \
#    gnupg \
#    g++ \
    procps \
    openssl \
    curl \
    git \
    unzip \
#    netcat-traditional \
    libxml2-dev \
    libpq-dev \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
#    libxslt1-dev \
    acl

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# pdo pdo_mysql xsl
RUN docker-php-ext-install pgsql pdo_pgsql zip gd intl opcache exif mbstring && \
    pecl install apcu

RUN docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-configure gd --with-jpeg --with-freetype

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Add xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

#CMD composer i -o ; wait-for-it localhost:15432 -- bin/console doctrine:migrations:migrate ;  php

