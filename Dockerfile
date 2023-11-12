FROM php:8.2-fpm

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
    curl \
    nodejs \
    npm

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

# Copiar el directorio existente a /var/www
COPY . /var/www/html
# copiar los permisos del directorio de la aplicación
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage

# cambiar el usuario actual por www
# USER www
# exponer el puerto 9000 e iniciar php-fpm server
#EXPOSE 9000
CMD ["php-fpm"]
