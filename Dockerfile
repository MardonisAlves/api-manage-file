# Use a imagem oficial do PHP 8.1 com FPM
FROM php:8.1-fpm

# Instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Instale as extensões do PHP necessárias
RUN docker-php-ext-install pdo_mysql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure o PHP-FPM
COPY php-fpm-pool.conf /etc/php/8.1/fpm/pool.d/www.conf

# Crie o diretório para os sockets do PHP-FPM
RUN mkdir -p /var/run/php

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do aplicativo para o contêiner
COPY . /var/www/html

# Instale as dependências do Composer
RUN composer install --no-interaction --optimize-autoloader

# Exponha a porta 9000 para o PHP-FPM
EXPOSE 9000

# Comando padrão ao iniciar o contêiner
CMD ["php-fpm"]
