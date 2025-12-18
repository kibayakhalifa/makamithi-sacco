# Use PHP 8.4 FPM
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    gettext-base \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Ensure .env exists
RUN cp .env.example .env || true

# Ensure Laravel cache directories exist
RUN mkdir -p storage/framework/cache/data storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache storage/framework \
    && chmod -R 775 storage bootstrap/cache storage/framework

# Install Composer (from official image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies without scripts (we'll run scripts at runtime)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy nginx config
COPY nginx.conf /etc/nginx/nginx.conf

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port for Railway
EXPOSE 80

# Use entrypoint script
CMD ["/usr/local/bin/docker-entrypoint.sh"]
