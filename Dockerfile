FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Configure GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    zip

# ==================================================
# FORCE APACHE TO USE ONLY ONE MPM
# ==================================================

# Remove every enabled MPM configuration
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
          /etc/apache2/mods-enabled/mpm_*.conf

# Enable ONLY prefork
RUN a2enmod mpm_prefork

# Enable Laravel rewrite
RUN a2enmod rewrite

# ==================================================
# Laravel
# ==================================================

WORKDIR /var/www/html

COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Create Laravel directories
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# Configure Apache for Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

# Allow Laravel .htaccess
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ==================================================
# CHECK APACHE BEFORE DEPLOYMENT
# ==================================================

RUN echo "===== ENABLED MPM MODULES =====" \
    && ls -la /etc/apache2/mods-enabled/ | grep mpm || true \
    && echo "===== APACHE MPM MODULES =====" \
    && apache2ctl -M 2>&1 | grep mpm || true \
    && echo "===== APACHE CONFIG TEST =====" \
    && apache2ctl configtest

EXPOSE 80