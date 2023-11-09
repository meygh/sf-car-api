FROM php:8.1-fpm
ARG TIMEZONE
WORKDIR /var/www

COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

COPY config/php.ini /usr/local/etc/php/conf.d/php.ini
COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update && apt-get install -y \
    vim \
    gnupg \
    g++ \
    procps \
    netcat-traditional \
    libpq-dev \
    openssl \
    curl \
    git \
    unzip \
    zlib1g-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev

RUN docker-php-ext-install pgsql pdo_pgsql zip gd intl opcache exif mbstring

# Add xdebug
RUN pecl install xdebug-3.2.1

RUN docker-php-ext-enable pdo_pgsql sodium xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-configure gd --with-jpeg --with-freetype

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Install composer and copy to usr/local/bin in order to run within the terminal
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set "sf" aleas standing for "php bin/console" in bashrc file
RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# Checks weather PostgresDB is ready to use and runs symfony doctrine migrations
CMD composer i -o ; wait-for-it postgresDB:5432 -- php bin/console doctrine:migrations:migrate ; php
