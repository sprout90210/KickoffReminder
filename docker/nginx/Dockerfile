FROM nginx:1.24.0

WORKDIR /var/www/app

COPY ./docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

COPY ./src/public /var/www/app/public/

ENV TZ=Asia/Tokyo

EXPOSE 80