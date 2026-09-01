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
# PHP EXTENSIONS
# ==================================================

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    zip


# ==================================================
# APACHE
# ==================================================

RUN a2dismod mpm_event mpm_worker mpm_worker_event 2>/dev/null || true

RUN a2enmod mpm_prefork
RUN a2enmod rewrite


# ==================================================
# LARAVEL
# ==================================================

WORKDIR /var/www/html

COPY . .


# ==================================================
# COMPOSER
# ==================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# ==================================================
# LARAVEL DIRECTORIES
# ==================================================

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache


# ==================================================
# APACHE DOCUMENT ROOT
# ==================================================

RUN sed -i \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf


RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf

RUN a2enconf laravel


# ==================================================
# PERMISSIONS
# ==================================================

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 \
    storage \
    bootstrap/cache


# ==================================================
# APACHE CONFIG
# ==================================================

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf


# ==================================================
# RAILWAY
# ==================================================

EXPOSE 8080

CMD ["bash", "-c", "set -e; PORT=${PORT:-8080}; echo PORT=$PORT; a2dismod mpm_event mpm_worker mpm_worker_event 2>/dev/null || true; a2enmod mpm_prefork; sed -i \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; apache2ctl configtest; exec apache2-foreground"]