FROM php:8.2-apache

# Installer les extensions PHP nécessaires, y compris PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev unzip curl git \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers Laravel dans l'image Docker
COPY . /var/www/html

# Modifier le dossier public comme racine Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Autoriser les permissions de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:cache

