# Panduan Deployment Sela-Website

Deploy backend Laravel 12 ke AWS EC2 dengan Supabase (PostgreSQL) dan HTTPS via Let's Encrypt.

```text
Flutter App  ──→  AWS EC2 (Nginx + PHP-FPM + SSL)  ──→  Supabase (PostgreSQL)
```

---

## Prasyarat

- Akun AWS (Free Tier).
- Akun [Supabase](https://supabase.com) (Gratis).
- Domain dengan A record ke IP EC2 (wajib untuk SSL).
- SSH Key Pair (`.pem` file).

---

## 1. Setup Supabase

1. Buat project baru di [supabase.com](https://supabase.com), region **Singapore** (`ap-southeast-1`).
2. Set database password — simpan baik-baik.
3. Buka **Settings → Connect** :
   - Type: `URI`
   - Method: `Session pooler`


---

## 2. Launch EC2

1. AWS Console → **EC2** → **Launch Instance**.
2. Konfigurasi:
   - **Name**: `sela-api-server`
   - **AMI**: Ubuntu Server 24.04 LTS (Free tier eligible)
   - **Instance type**: `t2.micro`
   - **Key pair**: Create new → download `.pem`
   - **Security Group**:
     - Port 22 (SSH) — My IP
     - Port 80 (HTTP) — Anywhere
     - Port 443 (HTTPS) — Anywhere
   - **Storage**: 8 GB gp3
3. Launch, catat **Public IPv4 address**.

---

## 3. Setup Domain DNS

1. Di panel DNS (Cloudflare/Namecheap/dll), buat **A Record**:
   - Name: `dardcor` (atau subdomain Anda)
   - Value: IP EC2
   - Proxy: **OFF** (DNS Only — wajib untuk Let's Encrypt)
2. Verifikasi: `ping dardcor.acalypha.my.id` → harus resolve ke IP EC2.

> **Cloudflare**: Pastikan ikon awan **abu-abu** (DNS Only), bukan oranye (Proxied).

---

## 4. Setup Server

SSH ke EC2, clone repo, jalankan setup:

```bash
# SSH ke server
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP

# Clone repo
sudo git clone -b backend https://github.com/Dardcor/Sela-Website.git /var/www/sela-website

# Install system packages (PHP, Nginx, Composer, Certbot)
sudo bash /var/www/sela-website/deploy/setup-server.sh
```

Script ini install: PHP 8.2 + extensions, Composer, Nginx, Certbot.

---

## 5. Konfigurasi Environment

```bash
cd /var/www/sela-website

# Buat file .env dari template
sudo cp .env.example .env

# Edit dengan kredensial Supabase Anda
sudo nano .env
```

Yang perlu diubah di `.env`:

```env
APP_URL=https://dardcor.acalypha.my.id

DB_CONNECTION=pgsql
DB_URL=postgresql-session-pooler
```

Simpan: `Ctrl+O` → `Enter` → `Ctrl+X`.

---

## 6. Deploy

```bash
sudo bash /var/www/sela-website/deploy/deploy.sh
```

Script ini melakukan:
1. `git pull origin backend`
2. `composer install --no-dev`
3. Buat `.env` jika belum ada (dan stop agar Anda edit dulu)
4. `php artisan key:generate` (jika belum ada key)
5. `php artisan migrate --force`
6. Cache config, routes, views
7. Set permissions (`www-data`)
8. Konfigurasi Nginx + restart PHP-FPM

### Test (HTTP):

```bash
curl -X POST http://dardcor.acalypha.my.id/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"username":"testuser","email":"test@test.com","password":"password123"}'
```

---

## 7. Setup SSL (Let's Encrypt)

```bash
sudo bash /var/www/sela-website/deploy/setup-ssl.sh
```

Script ini:
1. Mendapatkan sertifikat SSL dari Let's Encrypt.
2. Konfigurasi Nginx untuk HTTPS + redirect HTTP → HTTPS.
3. Mengatur auto-renewal (setiap 60 hari, otomatis).

### Test (HTTPS):

```bash
curl -X POST https://dardcor.acalypha.my.id/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"username":"testuser","email":"test@test.com","password":"password123"}'
```

### Verifikasi SSL:

```bash
sudo certbot certificates        # Status sertifikat
sudo certbot renew --dry-run     # Test auto-renewal
```

---

## 8. Update Deployment

Setelah push kode baru ke GitHub:

```bash
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP
sudo bash /var/www/sela-website/deploy/deploy.sh
```

Script otomatis mendeteksi SSL aktif dan re-apply konfigurasi Certbot.

---

## Troubleshooting

| Masalah                      | Solusi                                                                |
| ---------------------------- | --------------------------------------------------------------------- |
| 502 Bad Gateway              | `sudo systemctl restart php8.2-fpm`                                   |
| Permission denied            | `sudo chown -R www-data:www-data /var/www/sela-website/storage`       |
| DB connection refused        | Cek Security Group (outbound port 5432) + kredensial `.env`           |
| SQLSTATE connection error    | Pastikan `DB_SSLMODE=require` di `.env`                               |
| Supabase paused              | Dashboard Supabase → klik "Unpause" (pause setelah 7 hari inaktif)    |
| 413 Request Entity Too Large | Nginx diset maks 10MB, naikkan `client_max_body_size` di nginx config |
| Certbot gagal                | Domain belum resolve ke EC2, atau Cloudflare proxy ON                 |
| SSL expired                  | `sudo certbot renew`                                                  |

Cek log Laravel:

```bash
tail -f /var/www/sela-website/storage/logs/laravel.log
```

---

## Struktur File Deploy

```text
deploy/
├── nginx/
│   └── sela-website.conf   # Nginx config (HTTP — Certbot adds HTTPS)
├── setup-server.sh          # Install system packages (sekali)
├── setup-ssl.sh             # Setup Let's Encrypt SSL (sekali)
└── deploy.sh                # Deploy app (setiap update)
```

---

## Ringkasan — Urutan Lengkap

```bash
# 1. SSH
ssh -i "your-key.pem" ubuntu@YOUR_EC2_IP

# 2. Clone
sudo git clone https://github.com/YOUR_USERNAME/Sela-Website.git /var/www/sela-website

# 3. Install system packages
sudo bash /var/www/sela-website/deploy/setup-server.sh

# 4. Configure .env
cd /var/www/sela-website
sudo cp .env.example .env
sudo nano .env              # ← isi kredensial Supabase

# 5. Deploy (composer install, key:generate, migrate, nginx, dll)
sudo bash deploy/deploy.sh

# 6. SSL
sudo bash deploy/setup-ssl.sh

# Done → https://dardcor.acalypha.my.id/api
```

---

## Catatan

- **AWS Free Tier**: 750 jam/bulan EC2 gratis selama 12 bulan pertama.
- **Supabase Free Tier**: Maks 500MB, auto-pause jika tidak aktif 7 hari.
- **SSL**: Sertifikat berlaku 90 hari, auto-renew setiap 60 hari oleh Certbot.
- **File Upload**: Disimpan di `storage/app/` pada EC2. Hilang jika instance dihapus.
