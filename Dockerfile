# ==============================================================================
# Multi-Stage Production Dockerfile for PPL SIAP Reborn (Laravel 9 / PHP 8.2 FPM)
# ==============================================================================

# Stage 1: Build Dependencies via Composer
FROM composer:2.7 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-scripts

# Stage 2: Production PHP-FPM Runtime
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    mariadb-client \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

# Copy vendor from stage 1 with www-data ownership
COPY --from=vendor --chown=www-data:www-data /app/vendor /var/www/vendor

# Copy application source with www-data ownership
COPY --chown=www-data:www-data . /var/www

# Clear stale cached manifests, run production package discovery, and ensure permissions
RUN rm -f /var/www/bootstrap/cache/*.php \
    && php artisan package:discover --ansi \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
