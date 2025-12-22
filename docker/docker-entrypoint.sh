#!/bin/bash
set -e

echo "==========================================="
echo "🚀 Starting Laravel Application on Railway"
echo "==========================================="

# Display environment info
echo "PHP Version: $(php -v | head -n1)"
echo "Composer Version: $(composer --version | head -n1)"
echo "Nginx Version: $(nginx -v 2>&1)"
echo "Current Directory: $(pwd)"
echo "PORT: ${PORT:-80}"
echo "APP_ENV: ${APP_ENV:-not set}"

# Check if .env exists, create from example if not
if [ ! -f ".env" ]; then
    echo "📝 .env file not found, creating from .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ Created .env file from .env.example"
    else
        echo "⚠️ Warning: .env.example not found!"
    fi
fi

# Generate application key if not set
if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null || grep -q '^APP_KEY=$' .env 2>/dev/null; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
    echo "✅ Application key generated"
fi

# Create necessary directories
echo "📁 Creating directories..."
mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# Set proper permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Optimize Laravel for production
echo "⚡ Optimizing Laravel..."

# Only cache if in production
if [ "${APP_ENV:-local}" = "production" ]; then
    echo "📦 Production environment detected, caching..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "🔧 Development environment, clearing cache..."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
fi

# Discover packages
echo "📦 Discovering packages..."
php artisan package:discover --ansi

# Link storage
echo "🔗 Linking storage..."
php artisan storage:link --force 2>/dev/null || true

# Run migrations if environment variable is set
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "🗄️ Running migrations..."
    php artisan migrate --force --no-interaction
fi

# Run seeders if environment variable is set
if [ "${RUN_SEEDERS:-false}" = "true" ]; then
    echo "🌱 Running seeders..."
    php artisan db:seed --force --no-interaction
fi

# Update Nginx configuration with actual port
echo "🌐 Configuring Nginx for port ${PORT:-80}..."
envsubst '\$PORT' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf 2>/dev/null || cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf

# Display final configuration
echo "📋 Final Configuration:"
echo "----------------------"
php artisan route:list --no-ansi | head -20
echo "..."

# Start PHP-FPM
echo "🚀 Starting PHP-FPM..."
php-fpm -D
echo "✅ PHP-FPM started"

# Test PHP-FPM
echo "🧪 Testing PHP-FPM..."
sleep 2
if pgrep -x "php-fpm" > /dev/null; then
    echo "✅ PHP-FPM is running"
else
    echo "❌ PHP-FPM failed to start"
    exit 1
fi

# Start Nginx
echo "🌐 Starting Nginx on port ${PORT:-80}..."
echo "==========================================="
echo "✅ Application is ready!"
echo "👉 Access at: http://localhost:${PORT:-80}"
echo "==========================================="

# Start Nginx in foreground
exec nginx -g 'daemon off;'