#!/bin/bash
# =============================================================================
# Sela-Website SSL Setup Script (Let's Encrypt)
# Run AFTER setup-server.sh and deploy.sh
# Usage: sudo bash setup-ssl.sh
#
# Prerequisites:
#   - Domain (dardcor.acalypha.my.id) A record must point to this EC2 IP
#   - Ports 80 and 443 open in EC2 Security Group
#   - Nginx running and serving the site on port 80
# =============================================================================

set -e

DOMAIN="dardcor.acalypha.my.id"
EMAIL=""

echo "========================================="
echo "  Sela-Website SSL Setup (Let's Encrypt)"
echo "========================================="

# --- 1. Validate domain is pointing to this server ---
echo "[1/4] Checking prerequisites..."

SERVER_IP=$(curl -s http://169.254.169.254/latest/meta-data/public-ipv4 2>/dev/null || echo "")
if [ -z "$SERVER_IP" ]; then
    echo "WARNING: Could not detect EC2 public IP. Continuing anyway..."
fi

# Check certbot is installed
if ! command -v certbot &> /dev/null; then
    echo "Certbot not found. Installing..."
    apt install -y certbot python3-certbot-nginx
fi

# --- 2. Get email for certificate notifications ---
echo "[2/4] Setting up certificate..."

if [ -z "$EMAIL" ]; then
    read -p "Enter your email for Let's Encrypt notifications (or press Enter to skip): " EMAIL
fi

# --- 3. Obtain SSL Certificate ---
echo "[3/4] Obtaining SSL certificate for $DOMAIN..."

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

# --- 4. Verify auto-renewal ---
echo "[4/4] Setting up auto-renewal..."

# Test renewal process
certbot renew --dry-run

# Ensure renewal timer is active
systemctl enable certbot.timer
systemctl start certbot.timer

echo ""
echo "========================================="
echo "  SSL setup complete!"
echo ""
echo "  Your API is now available at:"
echo "    https://$DOMAIN/api"
echo ""
echo "  Certificate auto-renews every 60 days."
echo "  Manual renewal: sudo certbot renew"
echo "  Check status:   sudo certbot certificates"
echo "========================================="
