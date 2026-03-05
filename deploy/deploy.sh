#!/bin/bash
# =============================================================================
# Sela-Website — Deploy
# Handles both first-run and subsequent deployments.
# Run after setup-server.sh and .env configuration.
#
# Usage: sudo bash deploy.sh
# =============================================================================

set -e

APP_DIR="/var/www/sela-website"
DOMAIN="dardcor.acalypha.my.id"

echo "==========================================="
echo "  Sela-Website — Deploy"
echo "==========================================="
echo ""

cd "$APP_DIR"

# 1. Pull latest code
echo "[1/8] Pulling latest code..."
git pull origin backend

# 2. Install PHP dependencies
echo "[2/8] Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Environment file
echo "[3/8] Checking environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "  .env created from .env.example"
    echo "  >>> EDIT .env WITH YOUR CREDENTIALS BEFORE CONTINUING <<<"
    echo "  Run: nano $APP_DIR/.env"
    exit 1
fi

# 4. Application key
echo "[4/8] Checking application key..."
if grep -q "^APP_KEY=$" .env; then
    php artisan key:generate
    echo "  Application key generated."
else
    echo "  Key already set, skipping."
fi

# 5. Database migration
echo "[5/8] Running migrations..."
php artisan migrate --force

# 6. Cache configuration
echo "[6/8] Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Storage & permissions
echo "[7/8] Storage link & permissions..."
php artisan storage:link 2>/dev/null || true
chown -R www-data:www-data "$APP_DIR"
chmod -R 755 "$APP_DIR"
chmod -R 775 "$APP_DIR/storage"
chmod -R 775 "$APP_DIR/bootstrap/cache"

# 8. Nginx & PHP-FPM
echo "[8/8] Configuring web server..."
cp "$APP_DIR/deploy/nginx/sela-website.conf" /etc/nginx/sites-available/sela-website
ln -sf /etc/nginx/sites-available/sela-website /etc/nginx/sites-enabled/sela-website
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx
systemctl restart php8.2-fpm

# If SSL cert already exists, re-run certbot to update nginx config
if [ -d "/etc/letsencrypt/live/$DOMAIN" ]; then
    certbot install --nginx -d "$DOMAIN" --redirect --non-interactive
    PROTOCOL="https"
else
    PROTOCOL="http"
fi

SERVER_IP=$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || echo "your-ec2-ip")

echo ""
echo "==========================================="
echo "  Deploy complete!"
echo ""
echo "  $PROTOCOL://$DOMAIN/api"
echo "  $PROTOCOL://$SERVER_IP/api"
echo "==========================================="
