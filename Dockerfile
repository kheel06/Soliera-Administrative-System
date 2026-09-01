FROM php:8.3-apache

# --------------------------------------------------
# Install system dependencies
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# Configure GD
# --------------------------------------------------
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# --------------------------------------------------
# Install PHP extensions
# --------------------------------------------------
RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    zip

# --------------------------------------------------
# Apache MPM
# --------------------------------------------------
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
          /etc/apache2/mods-enabled/mpm_*.conf

RUN a2enmod mpm_prefork rewrite

# --------------------------------------------------
# Laravel working directory
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# Copy application
# --------------------------------------------------
COPY . .

# --------------------------------------------------
# Create Laravel directories BEFORE composer install
# --------------------------------------------------
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# --------------------------------------------------
# Set permissions BEFORE composer install
# --------------------------------------------------
RUN chown -R www-data:www-data \
    bootstrap/cache \
    storage

RUN chmod -R 775 \
    bootstrap/cache \
    storage

# --------------------------------------------------
# Install Composer
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# Install PHP dependencies
# --------------------------------------------------
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# --------------------------------------------------
# Configure Apache for Laravel
# --------------------------------------------------
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

# --------------------------------------------------
# Laravel Apache configuration
# --------------------------------------------------
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf

RUN a2enconf laravel

# --------------------------------------------------
# Final permissions
# --------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# --------------------------------------------------
# Verify Apache
# --------------------------------------------------
RUN apache2ctl configtest

EXPOSE 80