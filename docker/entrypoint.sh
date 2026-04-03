#!/bin/sh
set -e

echo "🚀 Viet Hostel - Starting up..."

# Create required directories
mkdir -p /var/log/supervisor
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/testing
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/app/public
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Wait for MySQL to be ready
if [ -n "$DB_HOST" ]; then
    echo "⏳ Waiting for MySQL at $DB_HOST:${DB_PORT:-3306}..."
    max_tries=30
    counter=0
    while ! php -r "
        try {
            new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USERNAME}', '${DB_PASSWORD}');
            echo 'connected';
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        counter=$((counter + 1))
        if [ $counter -ge $max_tries ]; then
            echo "❌ Could not connect to MySQL after $max_tries attempts. Exiting."
            exit 1
        fi
        echo "⏳ MySQL not ready yet... (attempt $counter/$max_tries)"
        sleep 2
    done
    echo "✅ MySQL is ready!"
fi

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating application key..."
    export APP_KEY=$(php -r "echo 'base64:' . base64_encode(random_bytes(32));")
    echo "✅ APP_KEY generated: ${APP_KEY}"
fi

# Cache configuration
echo "📦 Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗃️ Running migrations..."
php artisan migrate --force

# Seed database if SEED_DATA is set (or on first run)
if [ "${SEED_DATA:-true}" = "true" ]; then
    echo "🌱 Checking if seeding is needed..."
    USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null || echo "0")
    if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
        echo "🌱 Seeding database with sample data..."
        php artisan db:seed --force
        echo "✅ Database seeded successfully!"
    else
        echo "ℹ️  Database already has data, skipping seed."
    fi
fi

# Create storage link
php artisan storage:link 2>/dev/null || true

echo "✅ Viet Hostel is ready! Starting services..."

exec "$@"
