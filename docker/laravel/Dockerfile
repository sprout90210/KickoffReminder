FROM php:8.2-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y \
  cron \
  vim \
  zip \
  unzip \
  git \
  && docker-php-ext-install pdo pdo_mysql \
  && pecl install xdebug && docker-php-ext-enable xdebug \
  && pecl install redis-5.3.4 && docker-php-ext-enable redis \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* 

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm@10.2.2

COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer
COPY ./docker/laravel/crontab /etc/cron.d/laravel-cron
COPY ./src /var/www/app

RUN chmod 0644 /etc/cron.d/laravel-cron \
  && crontab /etc/cron.d/laravel-cron \
  && touch /var/log/cron.log

CMD ["php-fpm", "-F"]