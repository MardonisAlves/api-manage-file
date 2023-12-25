# Use the official PHP 8.1 FPM image as a base image
FROM php:8.1-fpm

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    nano

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip pdo_pgsql

# Copy the Composer binary from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Remove the existing "uploads" directory if it exists
RUN rm -rf /var/www/html/uploads

# Copy the local content to the container, including the "uploads" directory
COPY . /var/www/html

# Cria um novo arquivo php.ini baseado no php.ini-development
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini


# Expose port 9000 (used by PHP-FPM)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm", "--nodaemonize"]

