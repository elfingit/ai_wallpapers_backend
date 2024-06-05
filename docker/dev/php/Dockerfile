FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zlib1g-dev \
    libpng-dev \
  && docker-php-ext-install pgsql pdo_pgsql gd

VOLUME /srv/app
WORKDIR /srv/app
CMD ["php", "artisan", "serve", "--port=8000", "--host=0.0.0.0"]
EXPOSE 8000
