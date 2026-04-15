# Etapa 1: Construir assets con Node.js
FROM node:20-alpine AS build-stage

WORKDIR /app

# Copiar archivos de dependencias
COPY package*.json ./

# Instalar dependencias de npm
RUN npm ci

# Copiar código fuente
COPY . .

# Construir assets
RUN npm run build

# Etapa 2: Imagen final con PHP y Apache
FROM php:8.3-apache

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto al contenedor (excluyendo node_modules y archivos innecesarios)
COPY . .

# Copiar assets construidos desde la etapa de build
COPY --from=build-stage /app/public/build ./public/build

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Ajustar permisos solo para escritura en storage y cache
RUN chmod -R 777 storage bootstrap/cache

# Cambiar DocumentRoot a public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Evitar warning de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copiar script de entrada
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Exponer puerto Apache
EXPOSE 80

# Comando por defecto
ENTRYPOINT ["/entrypoint.sh"]