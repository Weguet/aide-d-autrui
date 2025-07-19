FROM php:8.2-apache

# Installer extensions nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier app dans conteneur
COPY . /var/www/html

# Définir le bon répertoire
WORKDIR /var/www/html

# Fixer les droits
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Point Apache sur public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Générer clé app (au besoin)
RUN php artisan key:generate

EXPOSE 80

