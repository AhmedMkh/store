# Stage 1: Build PHP + Composer
FROM php:8.2-fpm as builder

# Install Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    make \
    autoconf

# Install PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache

# Enable OPcache
RUN docker-php-ext-enable opcache

# Install Redis PHP Extension (phpredis)
# RUN pecl install redis && docker-php-ext-enable redis

# Install Node.js LTS & npm
RUN curl -fsSL https://deb.nodesource.com/setup_current.x  | bash - \
  && apt-get install -y nodejs

# Install latest Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# Set Working Directory
WORKDIR /var/www/html

# Copy Project Files
COPY . /var/www/html

# Copy PHP.ini
COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini
