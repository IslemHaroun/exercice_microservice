#!/bin/sh

# Attendre que Consul soit disponible
sleep 10

# Enregistrer le service dans Consul
consul services register -name=school -port=8000 -address=school

# Démarrer le serveur Laravel
exec php artisan serve --host=0.0.0.0 --port=8000