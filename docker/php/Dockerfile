FROM php:8.0-fpm-alpine

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./www.conf /usr/local/etc/php-fpm.d/www.conf
# ADD ./php.ini /usr/local/etc/php/php.ini

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel
RUN mkdir -p /var/www/html
RUN chown laravel:laravel /var/www/html

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

