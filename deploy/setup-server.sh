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
echo "[1/8] Updating system packages..."
apt update && apt upgrade -y

# --- 2. Install PHP 8.2 + Extensions ---
echo "[2/8] Installing PHP 8.2 and extensions..."
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
echo "[3/8] Installing Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- 4. Install Nginx ---
echo "[4/8] Installing Nginx..."
apt install -y nginx

# --- 5. Install Certbot (Let's Encrypt) ---
echo "[5/8] Installing Certbot for SSL..."
apt install -y certbot python3-certbot-nginx

# --- 6. Configure Nginx ---
echo "[6/8] Configuring Nginx for Laravel..."
cp /var/www/sela-website/deploy/nginx/sela-website.conf /etc/nginx/sites-available/sela-website
ln -sf /etc/nginx/sites-available/sela-website /etc/nginx/sites-enabled/sela-website
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

# --- 7. Set Permissions ---
echo "[7/8] Setting file permissions..."
chown -R www-data:www-data /var/www/sela-website
chmod -R 755 /var/www/sela-website
chmod -R 775 /var/www/sela-website/storage
chmod -R 775 /var/www/sela-website/bootstrap/cache

# --- 8. Enable Services ---
echo "[8/8] Enabling services..."
systemctl enable php8.2-fpm
systemctl enable nginx
systemctl start php8.2-fpm
systemctl start nginx

echo ""
echo "========================================="
echo "  Server setup complete!"
echo "  Next steps:"
echo "    1. Configure .env (see DEPLOYMENT.md)"
echo "    2. Run deploy.sh to deploy the app"
echo "    3. Run setup-ssl.sh to enable HTTPS"
echo "========================================="
