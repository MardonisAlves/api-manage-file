# Use the official PHP 8.1 FPM image as a base image
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Expose port 9000 (used by PHP-FPM)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
