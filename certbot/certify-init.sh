#!/bin/sh
set -e

: "${CERTBOT_DOMAIN:?CERTBOT_DOMAIN is required}"
: "${CERTBOT_EMAIL:?CERTBOT_EMAIL is required}"
: "${CERTBOT_STAGING:=false}"

while ! nc -z app 80; do
  echo "Waiting for nginx on app:80..."
  sleep 5
done

echo "Requesting certificate for ${CERTBOT_DOMAIN}..."

STAGING_FLAG=""
if [ "$CERTBOT_STAGING" = "true" ]; then
  STAGING_FLAG="--staging"
fi

certbot certonly \
  --webroot \
  -w "/vol/www/" \
  -d "$CERTBOT_DOMAIN" \
  --email "$CERTBOT_EMAIL" \
  --force-renewal \
  --rsa-key-size 4096 \
  --agree-tos \
  --noninteractive \
  $STAGING_FLAG
