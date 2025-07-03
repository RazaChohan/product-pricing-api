FROM php:8.3-fpm

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Set correct permissions for var/ (important for Symfony)
RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var \
    && chmod -R 775 var

# Run Composer install with proper permissions
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && chown -R www-data:www-data vendor

# Switch to non-root user if needed (optional)
# USER www-data

# Start PHP-FPM
CMD ["php-fpm"]
