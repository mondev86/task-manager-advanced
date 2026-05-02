#!/bin/sh
set -e

cd /var/www/html

VITE_PORT="${VITE_PORT:-5174}"

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
  cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
  php artisan key:generate --ansi --force
fi

mkdir -p database bootstrap/cache storage/framework/{sessions,views,cache} storage/logs
touch database/database.sqlite
chmod -R ug+rw database bootstrap/cache storage 2>/dev/null || true

php artisan migrate --force --no-interaction

if [ ! -d node_modules ]; then
  npm install
fi

export VITE_DOCKER="${VITE_DOCKER:-1}"

# Un solo proceso: Vue (Vite) + Laravel; evita un segundo contenedor/imagen.
exec npx concurrently -k \
  -n vite,php \
  -c cyan,magenta \
  "npm run dev -- --host 0.0.0.0 --port ${VITE_PORT}" \
  "php artisan serve --host=0.0.0.0 --port=8000"
