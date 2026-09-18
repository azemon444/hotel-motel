#!/usr/bin/env bash
set -euo pipefail

# One-shot cPanel deployment for Sardar Catering (bdgss.com).
# Run from the app root:  bash deploy.sh
# Safe to re-run: fetches latest code, flattens public/, installs vendor, rebuilds caches.

ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT"

echo "==> Fetching latest code from GitHub"
if [ -d .git ]; then
    git fetch --all --prune
    git checkout -B main origin/main
else
    git init
    git remote add origin https://github.com/azemon444/hotel-motel.git
    git fetch --all --prune
    git checkout -B main origin/main
fi

echo "==> Flattening public/ into web root (cPanel layout)"
if [ -d public ]; then
    cp -r public/. .
    rm -rf public
fi

echo "==> Ensuring writable directories"
mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views
chmod -R 775 storage bootstrap/cache

echo "==> Installing dependencies (vendor/)"
if [ -n "${COMPOSER:-}" ]; then
    COMPOSER="$COMPOSER"
elif [ -f composer.phar ]; then
    COMPOSER="php composer.phar"
else
    curl -sS https://getcomposer.org/installer | php
    COMPOSER="php composer.phar"
fi
eval "$COMPOSER install --no-dev --optimize-autoloader --no-interaction"

echo "==> Rebuilding caches"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Done. Check the site:"
curl -s -o /dev/null -w "    https://bdgss.com -> %{http_code}\n" https://bdgss.com