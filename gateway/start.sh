#!/bin/sh

sleep 10

consul services register -name=gateway -port=8000 -address=gateway

exec php artisan serve --host=0.0.0.0 --port=8000