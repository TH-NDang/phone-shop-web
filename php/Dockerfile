# Use the official PHP image as a base image
FROM php:8.3-fpm-alpine as app

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN set -exu; \
    install-php-extensions pdo pdo_mysql mysqli

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY ./app/composer.* ./
RUN composer install --no-dev --no-interaction --no-progress --no-scripts --prefer-dist --optimize-autoloader

# Copy application files
COPY ./app .
RUN composer dump-autoload --optimize

# Development stage with Xdebug
FROM app as dev
ENV XDEBUG_MODE=off
COPY ./php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
RUN set -exu; \
    install-php-extensions xdebug
