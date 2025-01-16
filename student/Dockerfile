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
    libssl-dev \  
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Installation de MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Installation de Consul
RUN wget https://releases.hashicorp.com/consul/1.20.2/consul_1.20.2_linux_amd64.zip \
    && unzip consul_1.20.2_linux_amd64.zip \
    && mv consul /usr/local/bin/ \
    && rm consul_1.20.2_linux_amd64.zip

# Installation de Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Création du répertoire pour la configuration Consul
RUN mkdir -p /consul/config

# Téléchargement du script wait-for-it
RUN wget https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -O /wait-for-it.sh \
    && chmod +x /wait-for-it.sh

EXPOSE 8000

# Modification du CMD pour utiliser un script de démarrage avec wait-for-it
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY start.sh .
RUN chmod +x start.sh

# Exécution du script wait-for-it et démarrage de l'application
CMD ["/wait-for-it.sh", "school:8002", "--", "/usr/local/bin/docker-entrypoint.sh"]
