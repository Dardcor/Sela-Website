#!/bin/bash
# =============================================================================
# Sela-Website Deployment Script
# Run from the EC2 instance after setup-server.sh
# Usage: bash deploy.sh
# =============================================================================

set -e

APP_DIR="/var/www/sela-website"
DOMAIN="dardcor.acalypha.my.id"

echo "========================================="
echo "  Deploying Sela-Website"
echo "========================================="

cd "$APP_DIR"

# --- 1. Pull latest code ---
echo "[1/7] Pulling latest code..."
git pull origin backend

# --- 2. Install dependencies ---
echo "[2/7] Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# --- 3. Run migrations ---
echo "[3/7] Running database migrations..."
php artisan migrate --force

# --- 4. Cache config/routes/views ---
echo "[4/7] Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# --- 5. Create storage link ---
echo "[5/7] Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# --- 6. Update Nginx config (only if SSL not yet configured) ---
echo "[6/7] Updating Nginx configuration..."
if [ -d "/etc/letsencrypt/live/$DOMAIN" ]; then
    echo "  SSL detected — preserving Certbot-managed Nginx config."
    # Only reload to pick up any upstream changes (PHP-FPM sock, etc.)
    nginx -t && systemctl reload nginx
else
    cp "$APP_DIR/deploy/nginx/sela-website.conf" /etc/nginx/sites-available/sela-website
    nginx -t && systemctl reload nginx
fi

# --- 7. Restart PHP-FPM ---
echo "[7/7] Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

# Detect protocol (HTTPS if cert exists)
if [ -d "/etc/letsencrypt/live/$DOMAIN" ]; then
    PROTOCOL="https"
else
    PROTOCOL="http"
fi

SERVER_IP=$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || echo 'your-ec2-ip')

echo ""
echo "========================================="
echo "  Deployment complete!"
echo "  API available at:"
echo "    $PROTOCOL://$DOMAIN/api"
echo "    $PROTOCOL://$SERVER_IP/api"
echo "========================================="
