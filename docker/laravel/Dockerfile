FROM php:8.2-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
  cron \
  vim \
  && docker-php-ext-install pdo pdo_mysql \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* 

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm@9.7.2

COPY --from=composer:2.5.7 /usr/bin/composer /usr/local/bin/composer
COPY ./docker/laravel/php.ini /usr/local/etc/php/
COPY ./docker/laravel/crontab /etc/cron.d/laravel-cron.sh
COPY ./src /var/www/app

RUN crontab /etc/cron.d/laravel-cron.sh \
  && touch /var/log/cron.log \
  && chmod 0644 /etc/cron.d/laravel-cron.sh

CMD ["php-fpm", "-F"]