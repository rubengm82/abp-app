#!/bin/bash
set -e

echo "Generando APP_KEY si no existe..."
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    php artisan key:generate --force || true
else
    echo "APP_KEY ya está configurado."
fi

echo "Asignando permisos..."
chmod -R 777 storage bootstrap/cache

DB_HOST=${DB_HOST:-mariadb}

if php -r "try { \$pdo = new PDO('mysql:host=$DB_HOST;dbname=vallparadis', 'vallparadis', 'LaP1n3d4Badalona@'); } catch (Exception \$e) { exit(1); }" 2>/dev/null; then
    echo "Base de datos disponible!"
    echo "Ejecutando migraciones..."
    php artisan migrate --force || true
    echo "Ejecutando seed..."
    php artisan db:seed --force || true
else
    echo "Base de datos no disponible, iniciando sin migraciones..."
fi

echo "Limpiando cachés..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "Iniciando Apache..."
exec apache2-foreground