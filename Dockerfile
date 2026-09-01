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
    curl \
    && rm -rf /var/lib/apt/lists/*


# ==================================================
# NODE.JS + NPM
# ==================================================

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && node --version \
    && npm --version


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
# LARAVEL DIRECTORIES
# ==================================================

RUN mkdir -p \
    /var/www/html/bootstrap/cache \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs


# ==================================================
# COMPOSER
# ==================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# ==================================================
# NPM / VITE
# ==================================================

RUN npm install

RUN npm run build


# ==================================================
# PERMISSIONS
# ==================================================

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache


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
# VERIFY
# ==================================================

RUN echo "========================================"
RUN echo "VITE BUILD:"
RUN ls -lah /var/www/html/public/build || true

RUN echo "========================================"
RUN echo "VITE MANIFEST:"
RUN test -f /var/www/html/public/build/manifest.json

RUN echo "========================================"
RUN echo "APACHE MPM:"
RUN ls -la /etc/apache2/mods-enabled/ | grep mpm || true

RUN echo "========================================"
RUN echo "APACHE CONFIG:"
RUN apache2ctl configtest

RUN echo "========================================"


# ==================================================
# RAILWAY
# ==================================================

EXPOSE 8080


# ====================================================
# START===
# =====================================================

CMD ["bash", "-c", "set -e; PORT=${PORT:-8080}; echo \"PORT=$PORT\"; a2dismod mpm_event mpm_worker mpm_worker_event 2>/dev/null || true; a2enmod mpm_prefork; sed -i \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; apache2ctl configtest; exec apache2-foreground"]