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
# Fix Apache MPM
# PHP + Apache should use prefork
# --------------------------------------------------
RUN a2dismod mpm_event mpm_worker mpm_event 2>/dev/null || true \
    && a2enmod mpm_prefork

# --------------------------------------------------
# Enable Apache rewrite
# --------------------------------------------------
RUN a2enmod rewrite

# --------------------------------------------------
# Laravel working directory
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# Copy application
# --------------------------------------------------
COPY . .

# --------------------------------------------------
# Create Laravel directories
# --------------------------------------------------
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

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
# Allow Apache to serve Laravel
# --------------------------------------------------
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# --------------------------------------------------
# Laravel permissions
# --------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# --------------------------------------------------
# Verify Apache configuration during BUILD
# --------------------------------------------------
RUN apache2ctl configtest

# --------------------------------------------------
# Port
# --------------------------------------------------
EXPOSE 80