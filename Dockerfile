FROM php:8.3-apache

# ==================================================
# SYSTEM DEPENDENCIES
# ==================================================

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*


# ==================================================
# PHP GD
# ==================================================

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg


# ==================================================
# PHP EXTENSIONS
# ==================================================

RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    zip


# ==================================================
# APACHE
# ==================================================

# The official PHP Apache image uses prefork for mod_php.
# Explicitly disable all other MPMs.

RUN a2dismod mpm_event mpm_worker mpm_worker_event 2>/dev/null || true

RUN rm -f \
    /etc/apache2/mods-enabled/mpm_event.* \
    /etc/apache2/mods-enabled/mpm_worker.* \
    /etc/apache2/mods-enabled/mpm_worker_event.*


# Enable ONLY prefork
RUN a2enmod mpm_prefork

# Laravel URL rewriting
RUN a2enmod rewrite


# ==================================================
# LARAVEL
# ==================================================

WORKDIR /var/www/html

COPY . .


# ==================================================
# LARAVEL DIRECTORIES
# ==================================================

RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs


# ==================================================
# COMPOSER
# ==================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# ==================================================
# LARAVEL PERMISSIONS
# ==================================================

RUN chown -R www-data:www-data \
    /var/www/html

RUN chmod -R 775 \
    storage \
    bootstrap/cache


# ==================================================
# APACHE DOCUMENT ROOT
# ==================================================

RUN sed -i \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf


# ==================================================
# LARAVEL APACHE CONFIG
# ==================================================

RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf

RUN a2enconf laravel


# ==================================================
# APACHE SERVER NAME
# ==================================================

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf


# ==================================================
# VERIFY APACHE DURING BUILD
# ==================================================

RUN echo "========================================"
RUN echo "ENABLED MPM MODULES:"
RUN ls -la /etc/apache2/mods-enabled/ | grep mpm || true

RUN echo "========================================"
RUN echo "APACHE CONFIG TEST:"
RUN apache2ctl configtest

RUN echo "========================================"


# ==================================================
# RAILWAY
# ==================================================

EXPOSE 8080


# ==================================================
# START APACHE
# ==================================================

CMD ["bash", "-c", "\
set -e; \
PORT=${PORT:-8080}; \
echo '========================================'; \
echo 'RAILWAY PORT:' ${PORT}; \
echo '========================================'; \
echo 'Cleaning Apache MPM modules...'; \
a2dismod mpm_event mpm_worker mpm_worker_event 2>/dev/null || true; \
rm -f /etc/apache2/mods-enabled/mpm_event.*; \
rm -f /etc/apache2/mods-enabled/mpm_worker.*; \
rm -f /etc/apache2/mods-enabled/mpm_worker_event.*; \
a2enmod mpm_prefork; \
echo '========================================'; \
echo 'ENABLED MPM MODULES:'; \
ls -la /etc/apache2/mods-enabled/ | grep mpm || true; \
echo '========================================'; \
echo 'Configuring Apache port...'; \
sed -i \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf; \
sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; \
echo '========================================'; \
echo 'APACHE CONFIG TEST:'; \
apache2ctl configtest; \
echo '========================================'; \
exec apache2-foreground \
"]