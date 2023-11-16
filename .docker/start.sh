#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$role" = "app" ]; then
    exec apache2-foreground

elif [ "$role" = "scheduler" ]; then

    echo "Running the queue..."
    php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=90

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
