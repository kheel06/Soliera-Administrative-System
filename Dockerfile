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

# Remove all enabled MPM modules
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
          /etc/apache2/mods-enabled/mpm_*.conf

# Enable ONLY prefork
RUN a2enmod mpm_prefork

# Enable rewrite
RUN a2enmod rewrite

# --------------------------------------------------
# Laravel
# --------------------------------------------------
WORKDIR /var/www/html

COPY . .

# --------------------------------------------------
# Laravel directories
# MUST EXIST BEFORE composer install
# --------------------------------------------------
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# --------------------------------------------------
# Permissions
# --------------------------------------------------
RUN chown -R www-data:www-data \
    bootstrap/cache \
    storage \
    && chmod -R 775 \
    bootstrap/cache \
    storage

# --------------------------------------------------
# Composer
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# --------------------------------------------------
# Apache Laravel DocumentRoot
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
# Verify Apache during BUILD
# --------------------------------------------------
RUN echo "===== ENABLED MPM MODULES =====" \
    && ls -la /etc/apache2/mods-enabled/ | grep mpm || true \
    && echo "===== APACHE CONFIG TEST =====" \
    && apache2ctl configtest

EXPOSE 80

# --------------------------------------------------
# FORCE MPM FIX AT RUNTIME
# --------------------------------------------------
CMD ["bash", "-c", "rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf && a2enmod mpm_prefork && exec apache2-foreground"]