FROM php:8.3-cli
RUN apt-get update && apt-get install -y --no-install-recommends git unzip libicu-dev libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring bcmath exif pcntl gd intl zip \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/madar-entrypoint
RUN chmod +x /usr/local/bin/madar-entrypoint
EXPOSE 8000
ENTRYPOINT ["madar-entrypoint"]
