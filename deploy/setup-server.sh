#!/bin/bash
# =============================================================================
# Sela-Website EC2 Server Setup Script
# Run as root on a fresh Ubuntu 22.04/24.04 EC2 instance
# Usage: sudo bash setup-server.sh
# =============================================================================

set -e

echo "========================================="
echo "  Sela-Website EC2 Server Setup"
echo "========================================="

# --- 1. System Update ---
echo "[1/7] Updating system packages..."
apt update && apt upgrade -y

# --- 2. Install PHP 8.2 + Extensions ---
echo "[2/7] Installing PHP 8.2 and extensions..."
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y \
    php8.2-fpm \
    php8.2-pgsql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-curl \
    php8.2-zip \
    php8.2-gd \
    php8.2-tokenizer \
    php8.2-intl \
    unzip \
    curl \
    git

# --- 3. Install Composer ---
echo "[3/7] Installing Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- 4. Install Nginx ---
echo "[4/7] Installing Nginx..."
apt install -y nginx

# --- 5. Configure Nginx ---
echo "[5/7] Configuring Nginx for Laravel..."
cp /var/www/sela-website/deploy/nginx/sela-website.conf /etc/nginx/sites-available/sela-website
ln -sf /etc/nginx/sites-available/sela-website /etc/nginx/sites-enabled/sela-website
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

# --- 6. Set Permissions ---
echo "[6/7] Setting file permissions..."
chown -R www-data:www-data /var/www/sela-website
chmod -R 755 /var/www/sela-website
chmod -R 775 /var/www/sela-website/storage
chmod -R 775 /var/www/sela-website/bootstrap/cache

# --- 7. Enable Services ---
echo "[7/7] Enabling services..."
systemctl enable php8.2-fpm
systemctl enable nginx
systemctl start php8.2-fpm
systemctl start nginx

echo ""
echo "========================================="
echo "  Server setup complete!"
echo "  Next: run deploy.sh to deploy the app"
echo "========================================="
