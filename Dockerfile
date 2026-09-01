FROM php:8.3-apache

# ==================================================
# System dependencies
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
# Configure PHP GD
# ==================================================
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg


# ==================================================
# PHP extensions
# ==================================================
RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    zip


# ==================================================
# Apache MPM
# ==================================================
# PHP 8.3 Apache requires prefork.
# Remove any other MPM that may be enabled.

RUN a2dismod mpm_event mpm_worker mpm_prefork || true

RUN a2enmod mpm_prefork

RUN a2enmod rewrite


# ==================================================
# Laravel directory
# ==================================================
WORKDIR /var/www/html


# ==================================================
# Copy Laravel application
# ==================================================
COPY . .


# ==================================================
# Laravel required directories
# ==================================================
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs


# ==================================================
# Permissions BEFORE Composer
# ==================================================
RUN chown -R www-data:www-data \
    bootstrap/cache \
    storage

RUN chmod -R 775 \
    bootstrap/cache \
    storage


# ==================================================
# Composer
# ==================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ==================================================
# Install Laravel dependencies
# ==================================================
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# ==================================================
# Laravel public directory
# ==================================================
RUN sed -i \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf


# ==================================================
# Laravel Apache configuration
# ==================================================
RUN printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf

RUN a2enconf laravel


# ==================================================
# Apache ServerName
# ==================================================
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf


# ==================================================
# Final permissions
# ==================================================
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 \
    storage \
    bootstrap/cache


# ==================================================
# Verify Apache
# ==================================================
RUN apache2ctl configtest


# ==================================================
# Railway
# ==================================================
EXPOSE 80


# ==================================================
# START
# ==================================================
CMD ["bash", "-c", "\
PORT=${PORT:-8080}; \
sed -i \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf; \
sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; \
exec apache2-foreground \
"]