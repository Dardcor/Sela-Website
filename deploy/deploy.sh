#!/bin/bash
# =============================================================================
# Sela-Website Deployment Script
# Run from the EC2 instance after setup-server.sh
# Usage: bash deploy.sh
# =============================================================================

set -e

APP_DIR="/var/www/sela-website"

echo "========================================="
echo "  Deploying Sela-Website"
echo "========================================="

cd "$APP_DIR"

# --- 1. Pull latest code ---
echo "[1/6] Pulling latest code..."
git pull origin backend

# --- 2. Install dependencies ---
echo "[2/6] Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# --- 3. Run migrations ---
echo "[3/6] Running database migrations..."
php artisan migrate --force

# --- 4. Cache config/routes/views ---
echo "[4/6] Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# --- 5. Create storage link ---
echo "[5/6] Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# --- 6. Restart PHP-FPM ---
echo "[6/6] Restarting PHP-FPM..."
sudo systemctl restart php8.2-fpm

echo ""
echo "========================================="
echo "  Deployment complete!"
echo "  API available at http://$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || echo 'your-ec2-ip')/api"
echo "========================================="
