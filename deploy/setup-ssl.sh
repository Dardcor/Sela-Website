#!/bin/bash
# =============================================================================
# Sela-Website — SSL Setup (Let's Encrypt)
# Run AFTER deploy.sh. Requires domain A record pointing to this server.
#
# Usage: sudo bash setup-ssl.sh
# =============================================================================

set -e

DOMAIN="dardcor.acalypha.my.id"

echo "==========================================="
echo "  Sela-Website — SSL Setup"
echo "==========================================="
echo ""

# 1. Check certbot
echo "[1/3] Checking prerequisites..."
if ! command -v certbot &> /dev/null; then
    echo "  Certbot not found. Installing..."
    apt install -y certbot python3-certbot-nginx
fi

# 2. Obtain certificate
echo "[2/3] Obtaining SSL certificate..."
read -p "Email for renewal notices (Enter to skip): " EMAIL

if [ -n "$EMAIL" ]; then
    certbot --nginx \
        -d "$DOMAIN" \
        --email "$EMAIL" \
        --agree-tos \
        --no-eff-email \
        --redirect \
        --non-interactive
else
    certbot --nginx \
        -d "$DOMAIN" \
        --register-unsafely-without-email \
        --agree-tos \
        --no-eff-email \
        --redirect \
        --non-interactive
fi

# 3. Auto-renewal
echo "[3/3] Verifying auto-renewal..."
certbot renew --dry-run
systemctl enable certbot.timer
systemctl start certbot.timer

echo ""
echo "==========================================="
echo "  SSL active!"
echo ""
echo "  https://$DOMAIN/api"
echo ""
echo "  Auto-renews every 60 days."
echo "  Manual: sudo certbot renew"
echo "  Status: sudo certbot certificates"
echo "==========================================="
