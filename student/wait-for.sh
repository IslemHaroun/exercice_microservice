#!/bin/bash

# Attendre que le service 'school' soit accessible avant de continuer
until curl -s http://school:8002/api/schools/2; do
  echo "Waiting for school service..."
  sleep 2
done

# Démarrer le serveur une fois le service 'school' prêt
exec "$@"
