#!/bin/bash

echo "Iniciando despliegue de ABP App..."

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Función para mostrar mensajes
log() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    error "No se encontró el archivo artisan. ¿Estás en el directorio correcto?"
    exit 1
fi

log "Actualizando código desde repositorio..."
git pull origin prod

log "Instalando dependencias de PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

log "Instalando dependencias de Node.js..."
npm install --production --silent

log "Compilando assets frontend..."
npm run build

log "Ejecutando migraciones de base de datos..."
php artisan migrate --force

log "Optimizando aplicación Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

log "Configurando permisos..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

log "Despliegue completado exitosamente!"
log "Tu aplicación debería estar disponible en https://abp.ldeluipy.es"

echo ""
warn "Recuerda verificar:"
echo "  - Archivo .env configurado correctamente"
echo "  - Virtual host de Apache configurado"
echo "  - Certificado SSL activo"