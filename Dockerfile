FROM php:8.4-fpm

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer y Node.js
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /var/www
COPY . .

# Instalar dependencias y optimizar Laravel para producción
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Configurar permisos de directorios
RUN mkdir -p storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# Crear script de arranque: Migra la BD, vincula el storage y corre PHP-FPM
RUN echo '#!/bin/sh\n\
php artisan migrate --force\n\
php artisan storage:link\n\
php-fpm' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

EXPOSE 9000
CMD ["/usr/local/bin/start.sh"]