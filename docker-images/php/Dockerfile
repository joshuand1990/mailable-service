FROM php:8.0-fpm-alpine
# lumen packages
RUN docker-php-ext-install tokenizer mysqli pdo_mysql
# memcached
ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev
RUN apk add --no-cache --update libmemcached-libs zlib autoconf
RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && apk add --no-cache --update --virtual .memcached-deps $MEMCACHED_DEPS \
    && pecl install memcached redis\
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/20_memcached.ini \
    && docker-php-ext-enable redis.so \
    && rm -rf /usr/share/php7 \
    && rm -rf /tmp/* \
    && apk del .memcached-deps .phpize-deps
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer