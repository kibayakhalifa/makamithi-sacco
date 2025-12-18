FROM php:8.2-apache

# Disable other MPMs and force prefork (required for mod_php)
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set Apache document root to Laravel public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache config paths
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copy project files
WORKDIR /var/www/html
COPY . .

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache
