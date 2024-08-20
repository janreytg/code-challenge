FROM php:8.3-fpm-alpine As base

RUN apk add --update linux-headers zlib-dev libpng-dev libzip-dev $PHPIZE_DEPS
RUN apk --no-cache add procps

RUN docker-php-ext-install exif
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install sockets

FROM base AS build-fpm

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY /project /var/www/html

#RUN composer i --prefer-dist --no-ansi --no-dev

FROM build-fpm AS develop

COPY /ops/docker/fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY /ops/docker/fpm/user.ini /usr/local/etc/php/conf.d/user.ini

#RUN chmod +x app-entrypoint.sh
#CMD ["./app-entrypoint.sh"]

FROM develop as production

RUN docker-php-ext-install opcache

RUN docker-php-ext-configure opcache --enable-opcache