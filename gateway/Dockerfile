FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    unzip \
    git \
    wget \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Installation de Consul
RUN wget https://releases.hashicorp.com/consul/1.20.2/consul_1.20.2_linux_amd64.zip \
    && unzip consul_1.20.2_linux_amd64.zip \
    && mv consul /usr/local/bin/ \
    && rm consul_1.20.2_linux_amd64.zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN mkdir -p /consul/config

COPY start.sh .
RUN chmod +x start.sh