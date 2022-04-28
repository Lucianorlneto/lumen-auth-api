FROM alpine:latest

# Installing PHP
RUN apk add --no-cache php8 \
php8-common \
php8-fpm \
php8-pdo \
php8-opcache \
php8-zip \
php8-phar \
php8-iconv \
php8-cli \
curl \
php8-curl \
php8-openssl \
php8-mbstring \
php8-tokenizer \
php8-fileinfo \
php8-json \
php8-xml \
php8-xmlwriter \
php8-simplexml \
php8-dom \
php8-pdo_pgsql \
php8-tokenizer \
php8-pecl-redis

RUN ln -s /usr/bin/php8 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# # copy all of the file in folder to /src
COPY . /src
WORKDIR /src

RUN ln -s storage/app/public public/storage

# RUN /usr/bin/php8 /usr/bin/composer update --ignore-platform-req=ext-fileinfo
RUN composer update --with-all-dependencies

WORKDIR /src/public

# EXPOSE 8080

# CMD [ "php", "-S 0.0.0.0:8080", "./index.php"]
CMD php -S 0.0.0.0:$PORT
