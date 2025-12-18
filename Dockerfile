FROM php:8.2-apache

# HARD RESET: remove all MPMs first
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_worker.load \
          /etc/apache2/mods-enabled/mpm_prefork.load

# Enable ONLY prefork + rewrite
RUN a2enmod mpm_prefork rewrite

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set document root to Laravel public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copy project
WORKDIR /var/www/html
COPY . .

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache
