FROM php:8.2-apache

# Copiar composer.lock y composer.json
# COPY composer.lock composer.json /var/www/html

WORKDIR /var/www/html

# Instalamos dependencias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl

RUN apt-get update && apt-get install -y \
    libonig-dev \
    autoconf \
    libz-dev \
    libzip-dev

# Borramos cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos extensiones
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd zip
RUN docker-php-ext-configure gd --with-freetype=/usr/include/

# Installer composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# agregar usuario para la aplicación laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www/html
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/start.sh /usr/local/bin/start

RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage

CMD ["/usr/local/bin/start", "php-fpm"]
