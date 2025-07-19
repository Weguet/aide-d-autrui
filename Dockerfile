FROM php:8.2-apache

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier les fichiers Laravel
COPY . /var/www/html

WORKDIR /var/www/html

# Fixer les droits pour Laravel
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copier Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# NE PAS faire de `php artisan key:generate` ici
# Il faut le faire au runtime, quand l'app est prête

# Changer Apache root vers public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]


