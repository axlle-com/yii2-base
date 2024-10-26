# Используем официальный образ PHP
FROM php:8.3-fpm

# Устанавливаем необходимые расширения и инструменты
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libicu-dev \
    libmcrypt-dev \
    libcurl4-openssl-dev \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip xml mysqli pdo pdo_mysql pcntl intl \
    && pecl install redis \
    && docker-php-ext-enable redis

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add user
RUN getent group www || groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN mkdir /var/log/xdebug
RUN chown -R www:www /var/log/xdebug

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Устанавливаем зависимости проекта
COPY . /var/www/html

USER www

WORKDIR /var/www/html

VOLUME ["/var/www/html", "/var/run/php-fpm", "/var/log/php"]

EXPOSE 9000

CMD ["php-fpm"]
