#!/bin/bash
# =============================================================================
# Sela-Website — Server Setup
# Installs system packages on a fresh Ubuntu 22.04/24.04 EC2 instance.
# Run once. Does NOT touch the Laravel app — use deploy.sh for that.
#
# Usage: sudo bash setup-server.sh
# =============================================================================

set -e

echo "==========================================="
echo "  Sela-Website — Server Setup"
echo "==========================================="
echo ""

# 1. System update
echo "[1/6] Updating system packages..."
apt update && apt upgrade -y

# 2. PHP 8.2 + extensions
echo "[2/6] Installing PHP 8.2..."
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

# 3. Composer
echo "[3/6] Installing Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Nginx
echo "[4/6] Installing Nginx..."
apt install -y nginx

# 5. Certbot
echo "[5/6] Installing Certbot..."
apt install -y certbot python3-certbot-nginx

# 6. Enable services
echo "[6/6] Enabling services..."
systemctl enable php8.2-fpm
systemctl enable nginx
systemctl start php8.2-fpm
systemctl start nginx

echo ""
echo "==========================================="
echo "  Server setup complete!"
echo ""
echo "  Next: bash /var/www/sela-website/deploy/deploy.sh"
echo "==========================================="
