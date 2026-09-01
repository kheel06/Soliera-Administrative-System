FROM php:8.3-apache

# --------------------------------------------------
# System dependencies
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
# PHP extensions
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

# Remove all MPM modules that may be enabled
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
          /etc/apache2/mods-enabled/mpm_*.conf

# Enable ONLY prefork MPM
RUN a2enmod mpm_prefork

# Enable Apache rewrite
RUN a2enmod rewrite

# --------------------------------------------------
# Laravel working directory
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# Copy Laravel application
# --------------------------------------------------
COPY . .

# --------------------------------------------------
# Create Laravel directories
# MUST EXIST BEFORE composer install
# --------------------------------------------------
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# --------------------------------------------------
# Set Laravel permissions
# --------------------------------------------------
RUN chown -R www-data:www-data \
    bootstrap/cache \
    storage \
    && chmod -R 775 \
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
# Configure Apache DocumentRoot
# Laravel must use /public
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
# Final Laravel permissions
# --------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# --------------------------------------------------
# Apache ServerName
# Prevent AH00558 warning
# --------------------------------------------------
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# --------------------------------------------------
# Verify Apache configuration during BUILD
# --------------------------------------------------
RUN echo "===== ENABLED MPM MODULES =====" \
    && ls -la /etc/apache2/mods-enabled/ | grep mpm || true \
    && echo "===== APACHE CONFIG TEST =====" \
    && apache2ctl configtest

# --------------------------------------------------
# Railway
# --------------------------------------------------
EXPOSE 80

# --------------------------------------------------
# START APACHE USING RAILWAY'S PORT
# --------------------------------------------------
CMD ["bash", "-c", "rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf && a2enmod mpm_prefork && sed -i \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf && exec apache2-foreground"]