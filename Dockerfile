# Dockerfile
FROM php:8.2-cli

RUN apt-get update -y && apt-get install -y \
    libmcrypt-dev \
    libonig-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo mbstring

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN export COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

RUN docker-php-ext-install pdo_mysql

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000