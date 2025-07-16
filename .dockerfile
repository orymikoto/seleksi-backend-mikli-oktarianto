# Stage 1: Builder
FROM composer:2 as builder

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist
COPY . .
RUN php artisan optimize

# Stage 2: Production
FROM php:8.2-fpm-alpine

WORKDIR /app

# Install PostgreSQL and required extensions
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    gd \
    opcache

COPY --from=builder /app .

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

CMD ["php-fpm"]