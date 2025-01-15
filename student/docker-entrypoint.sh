#!/bin/bash

# Attendre que Consul soit disponible
until nc -z consul 8500; do
    echo "Waiting for Consul..."
    sleep 1
done

# Démarrer l'agent Consul en arrière-plan
consul agent -join consul -config-dir=/consul/config &

# Démarrer PHP-FPM en arrière-plan
php-fpm -D

# Démarrer le serveur Laravel
php artisan serve --host=0.0.0.0 --port=8001