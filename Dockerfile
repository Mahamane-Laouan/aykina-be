# Étape 1 : Builder l'application
FROM composer:2 AS build

WORKDIR /app

# Copier uniquement ce dont Composer a besoin
COPY composer.json composer.lock ./
COPY artisan ./
COPY bootstrap/ bootstrap/
COPY config/ config/
COPY database/ database/

# Installer les dépendances sans scripts artisan
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le reste du projet
COPY . .

# Étape 2 : Image finale avec PHP + Nginx
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY --from=build /app ./

# Variables d'environnement Laravel
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV WEBROOT=/var/www/html/public
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
# Exécuter le script de build après l'installation
RUN chmod +x /var/www/html/render-build.sh && /var/www/html/render-build.sh
