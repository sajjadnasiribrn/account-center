#!/bin/sh
set -e

: "${APP_ENV:=local}"
: "${NGINX_SERVER_NAME:=127.0.0.1 localhost}"
: "${NGINX_ROOT:=/var/www/html/public}"
: "${CORS_ALLOW_ORIGIN:=*}"
: "${SSL_CERTIFICATE:=/etc/nginx/ssl/fullchain.pem}"
: "${SSL_CERTIFICATE_KEY:=/etc/nginx/ssl/privkey.pem}"

if [ "$APP_ENV" = "production" ] && [ -f "$SSL_CERTIFICATE" ] && [ -f "$SSL_CERTIFICATE_KEY" ]; then
  echo "SSL certificate detected, using HTTPS config."
  NGINX_TEMPLATE=/etc/nginx/default-ssl.conf
else
  if [ "$APP_ENV" = "production" ]; then
    echo "SSL certificate not found at $SSL_CERTIFICATE. Falling back to HTTP config until certbot issues one."
  fi
  NGINX_TEMPLATE=/etc/nginx/default.conf
fi

envsubst '$NGINX_SERVER_NAME $NGINX_ROOT $CORS_ALLOW_ORIGIN $SSL_CERTIFICATE $SSL_CERTIFICATE_KEY' \
  < "$NGINX_TEMPLATE" > /etc/nginx/conf.d/default.conf

nginx -t
exec nginx -g 'daemon off;'
