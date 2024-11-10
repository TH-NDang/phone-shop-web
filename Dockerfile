FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
	&& docker-php-ext-install mysqli pdo pdo_mysql \
	&& a2enmod rewrite \
	&& sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
