FROM composer:1 as composer
COPY . /var/www/html
WORKDIR /var/www/html
ENV APP_ENV=prod

RUN composer install --no-scripts --ignore-platform-reqs \
    && composer dump-autoload --optimize \
    && composer run auto-scripts \
    && php bin/console enqueue:setup-broker

# next stage #

FROM alpine:3.11
COPY --from=composer /var/www/html /var/www/html
WORKDIR /var/www/html
ENV APP_ENV=prod \
    ENQUEUE_DSN=sqlite:///%kernel.project_dir%/var/sqlite/queue.sq3

RUN apk add --no-cache php7-fpm \
       php7-cli \
       php7-ctype \
       php7-dom \
       php7-iconv \
       php7-json \
       php7-mbstring \
       php7-openssl \
       php7-session \
       php7-pdo_sqlite \
       php7-tokenizer \
       php7-zip \
       supervisor \
       fcgi \
    && cp docker/*-fpm.conf /etc/php7/php-fpm.d/ \
    && php bin/console cache:warmup \
    && crontab /var/www/html/docker/crontab

ENTRYPOINT ["supervisord", "--configuration", "/var/www/html/docker/supervisord.conf"]
