#!/usr/bin/env sh

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

wait_for_database() {
    db_host=${DB_HOST:-mysql}
    db_port=${DB_PORT:-3306}
    attempts=1
    max_attempts=30

    echo "Waiting for database at ${db_host}:${db_port}..."

    while [ $attempts -le $max_attempts ]; do
        if php -r "exit(@fsockopen('${db_host}', ${db_port}) ? 0 : 1);"; then
            echo "Database is reachable."
            return 0
        fi

        echo "Database not ready (attempt ${attempts}/${max_attempts}); retrying in 2s..."
        attempts=$((attempts + 1))
        sleep 2
    done

    echo "Database did not become reachable in time."
    exit 1
}

#if [ "$env" != "local" ]; then
#    echo "Caching configuration..."
#    (cd /var/www/html && php artisan config:cache && php artisan route:cache && php artisan view:cache)
#fi

if [ "$role" = "app" ]; then

        wait_for_database
        echo "***"
        php artisan migrate
        echo "***"
        php artisan optimize:clear
        echo "***"
        php artisan config:clear
        echo "***"

    exec php-fpm -y /usr/local/etc/php-fpm.conf -R
#    /usr/local/bin/docker-php-entrypoint "$@"

elif [ "$role" = "queue" ]; then
    echo "🔁 Clearing Laravel cache before Supervisor reload"
        wait_for_database
        php artisan migrate
        php artisan optimize:clear
        php artisan config:clear

        mkdir -p /var/log/supervisor

        echo "🚀 Starting Supervisor..."
        /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

        sleep 3

        echo "🔁 Forcing reload of Supervisor programs (worker restart)"
        supervisorctl update
        supervisorctl restart all

        echo "📜 Tailing Supervisor log..."
        tail -f /var/log/supervisor/supervisord.log

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
