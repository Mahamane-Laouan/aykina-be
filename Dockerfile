# Étape 1 : Builder l'application
FROM composer:2 AS build

WORKDIR /app

# Copier les fichiers nécessaires pour Composer
COPY composer.json composer.lock ./
COPY artisan .   # <--- On copie artisan avant composer install pour éviter l'erreur
COPY database/ database/
COPY config/ config/

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

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
