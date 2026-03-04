# Panduan Deployment Sela-Website

Panduan ini berisi langkah-langkah lengkap untuk mendeploy backend Laravel 12 ke AWS EC2 dengan Supabase sebagai database PostgreSQL. Panduan ini dirancang untuk mahasiswa dengan pengetahuan terminal dasar.

---

## 1. Arsitektur Deployment

```text
+-------------------+       +-----------------------+       +------------------------+
|   Flutter App     | ----> |      AWS EC2          | ----> |       Supabase         |
|   (Mobile/Web)    |       |   (Laravel API)       |       |     (PostgreSQL)       |
+-------------------+       +-----------------------+       +------------------------+
      Frontend                    Backend Server                  Cloud Database
                                  + Nginx + SSL
                                  (Let's Encrypt)
```

---

## 2. Prasyarat

Sebelum memulai, pastikan Anda memiliki:
- Akun AWS (bisa menggunakan Free Tier).
- Akun Supabase (Gratis).
- Git terinstall di komputer lokal.
- SSH Key Pair untuk akses EC2.
- Domain yang sudah diarahkan (A record) ke IP Publik EC2 (wajib untuk SSL).

---

## 3. Part A — Setup Supabase Database

Supabase digunakan sebagai database PostgreSQL managed yang stabil dan gratis.

1. Buat akun di [supabase.com](https://supabase.com).
2. Klik **New Project** dan pilih region terdekat: Singapore (`ap-southeast-1`).
3. Set database password dan simpan baik-baik di tempat aman.
4. Tunggu hingga project selesai proses provisioning.
5. Buka menu **Settings** (ikon gear) → **Database** → **Connection info**.
6. Catat detail berikut:
   - **Host**: `db.xxxx.supabase.co`
   - **Port**: `5432`
   - **Database name**: `postgres`
   - **User**: `postgres`
   - **Password**: (Password yang Anda buat sebelumnya)
7. **Connection Pooling**: Jika traffic tinggi, gunakan port `6543` (Transaction mode). Cari infonya di **Settings** → **Database** → **Connection Pooling**.
8. Format connection string biasanya: `postgresql://postgres:[password]@db.xxxx.supabase.co:5432/postgres`

---

## 4. Part B — Launch EC2 Instance

Gunakan AWS Console untuk membuat server virtual.

1. Login ke AWS Console → cari **EC2** → Klik **Launch Instance**.
2. **Name**: `sela-api-server`.
3. **AMI**: Ubuntu Server 24.04 LTS (Pastikan ada label *Free tier eligible*).
4. **Instance type**: `t2.micro` (gratis) atau `t3.micro`.
5. **Key pair**: Pilih **Create new key pair** → Beri nama → Download file `.pem` → Simpan di folder aman.
6. **Network Settings** (Security Group):
   - Centang **Allow SSH traffic** (Port 22) — pilih *My IP*.
   - Centang **Allow HTTPS traffic** (Port 443) — dari *Anywhere*.
   - Centang **Allow HTTP traffic** (Port 80) — dari *Anywhere*.
7. **Storage**: Ganti ke 8 GB gp3 (Free tier).
8. Klik **Launch Instance**.
9. Buka daftar instance dan catat **Public IPv4 address** server Anda.

---

## 5. Part C — Setup Domain DNS

Sebelum setup SSL, domain harus diarahkan ke EC2.

1. Login ke panel DNS domain Anda (Cloudflare, Namecheap, dll).
2. Buat **A Record**:
   - **Name**: `dardcor` (atau sesuai subdomain Anda)
   - **Value**: `<Public IPv4 EC2 Anda>`
   - **TTL**: Auto
   - **Proxy**: OFF / DNS Only (jangan gunakan proxy Cloudflare jika pakai Let's Encrypt)
3. Tunggu propagasi DNS (biasanya 1-5 menit, maksimal 24 jam).
4. Verifikasi dengan: `ping dardcor.acalypha.my.id` — harus resolve ke IP EC2 Anda.

> **PENTING**: Jika menggunakan Cloudflare, pastikan ikon awan berwarna **abu-abu** (DNS Only), bukan **oranye** (Proxied). Let's Encrypt perlu akses langsung ke server untuk verifikasi domain.

---

## 6. Part D — Setup Server (SSH ke EC2)

Sekarang kita akan mengkonfigurasi server Ubuntu agar bisa menjalankan Laravel.

1. Masuk ke server via SSH:
   ```bash
   ssh -i "path/to/your-key.pem" ubuntu@your-ec2-ip
   ```
   *Note untuk Mac/Linux: Jalankan `chmod 400 your-key.pem` terlebih dahulu.*

2. Clone repositori ke folder `/var/www/`:
   ```bash
   sudo git clone https://github.com/YOUR_USERNAME/Sela-Website.git /var/www/sela-website
   ```
   *Jika repo bersifat private, gunakan Personal Access Token atau tambahkan SSH Key EC2 ke GitHub.*

3. Jalankan script setup otomatis:
   ```bash
   sudo bash /var/www/sela-website/deploy/setup-server.sh
   ```

4. **Apa yang dilakukan script ini?**
   - Update sistem paket.
   - Install PHP 8.2 dan ekstensi yang dibutuhkan Laravel.
   - Install Composer.
   - Install dan konfigurasi Nginx.
   - Install Certbot (untuk SSL Let's Encrypt).
   - Mengatur permission folder agar web server bisa menulis file.

---

## 7. Part E — Configure Environment

Konfigurasi file `.env` agar server terhubung ke Supabase.

1. Pindah ke direktori project:
   ```bash
   cd /var/www/sela-website
   ```
2. Copy template environment:
   ```bash
   cp .env.example .env
   ```
3. Generate application key:
   ```bash
   php artisan key:generate
   ```
4. Edit file `.env` menggunakan nano atau vim:
   ```bash
   nano .env
   ```
   Sesuaikan nilai berikut dengan data dari Supabase dan EC2:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://dardcor.acalypha.my.id
   
   DB_CONNECTION=pgsql
   DB_HOST=db.YOUR_PROJECT_REF.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=your-supabase-password
   DB_SSLMODE=require
   ```
   *Tekan `Ctrl+O` lalu `Enter` untuk save, dan `Ctrl+X` untuk exit.*

5. Jalankan migrasi database:
   ```bash
   php artisan migrate --force
   ```
6. Cache konfigurasi untuk performa maksimal:
   ```bash
   php artisan config:cache && php artisan route:cache
   ```

---

## 8. Part F — Deploy & Test (HTTP)

1. Jalankan script deploy untuk memastikan semua dependensi terinstall:
   ```bash
   bash /var/www/sela-website/deploy/deploy.sh
   ```

2. Test API dari komputer lokal menggunakan `curl` atau Postman:
   ```bash
   # Register User Baru
   curl -X POST http://dardcor.acalypha.my.id/api/register \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"username":"testuser","email":"test@test.com","password":"password123"}'
   
   # Login
   curl -X POST http://dardcor.acalypha.my.id/api/login \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"email":"test@test.com","password":"password123"}'
   ```

3. Verifikasi data telah masuk di **Supabase Dashboard** → **Table Editor** → table `users`.

---

## 9. Part G — Setup SSL (Let's Encrypt) 🔒

Setelah API berjalan via HTTP, aktifkan HTTPS menggunakan Let's Encrypt.

### Prasyarat SSL:
- ✅ Domain sudah diarahkan ke IP EC2 (Part C).
- ✅ Port 80 dan 443 terbuka di Security Group EC2.
- ✅ Nginx sudah berjalan dan melayani site via HTTP.

### Jalankan script SSL:

```bash
sudo bash /var/www/sela-website/deploy/setup-ssl.sh
```

### Apa yang dilakukan script ini?
1. Memverifikasi Certbot terinstall.
2. Meminta email untuk notifikasi perpanjangan sertifikat (opsional).
3. Mendapatkan sertifikat SSL dari Let's Encrypt secara otomatis.
4. Mengkonfigurasi Nginx untuk HTTPS + auto-redirect HTTP → HTTPS.
5. Mengatur auto-renewal sertifikat (setiap 60 hari, otomatis).

### Verifikasi SSL:

```bash
# Test HTTPS
curl -I https://dardcor.acalypha.my.id/api

# Cek status sertifikat
sudo certbot certificates

# Test auto-renewal
sudo certbot renew --dry-run
```

### Test API via HTTPS:

```bash
# Register User Baru
curl -X POST https://dardcor.acalypha.my.id/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"username":"testuser","email":"test@test.com","password":"password123"}'

# Login
curl -X POST https://dardcor.acalypha.my.id/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@test.com","password":"password123"}'
```

---

## 10. Part H — Update Deployment (Deploy Ulang)

Jika Anda melakukan perubahan kode di komputer lokal dan sudah push ke GitHub, lakukan langkah ini di server:

```bash
ssh -i "your-key.pem" ubuntu@your-ec2-ip
cd /var/www/sela-website
bash deploy/deploy.sh
```

> **Catatan**: Script deploy.sh sudah otomatis mendeteksi apakah SSL aktif dan menampilkan URL yang sesuai (HTTP atau HTTPS).

---

## 11. Troubleshooting

Beberapa masalah umum yang mungkin terjadi:

- **502 Bad Gateway**: PHP-FPM mungkin mati. Cek dengan: `sudo systemctl restart php8.2-fpm`.
- **Permission denied**: Pastikan owner folder benar: `sudo chown -R www-data:www-data /var/www/sela-website/storage`.
- **DB connection refused**:
  - Cek apakah Security Group EC2 memperbolehkan akses keluar ke port 5432.
  - Cek kembali kredensial di `.env`.
- **SQLSTATE connection error**: Pastikan `DB_SSLMODE=require` sudah ada di `.env`.
- **Supabase project paused**: Project gratis akan "tidur" jika tidak ada aktivitas selama 7 hari. Buka dashboard Supabase dan klik "Unpause".
- **413 Request Entity Too Large**: Konfigurasi Nginx sudah diset maksimal 10MB untuk upload file.
- **Cek Log Laravel**: Jika error tidak jelas, lihat log: `tail -f /var/www/sela-website/storage/logs/laravel.log`.

### Troubleshooting SSL:

- **Certbot gagal mendapatkan sertifikat**:
  - Pastikan domain sudah resolve ke IP EC2: `dig dardcor.acalypha.my.id`
  - Pastikan port 80 terbuka: `sudo ufw status` atau cek Security Group AWS.
  - Jika pakai Cloudflare, matikan proxy (awan abu-abu, bukan oranye).
- **Sertifikat expired**: Jalankan `sudo certbot renew` secara manual.
- **Cek status renewal timer**: `sudo systemctl status certbot.timer`.
- **Nginx error setelah SSL**: Cek config: `sudo nginx -t` dan restart: `sudo systemctl restart nginx`.

---

## 12. Catatan Penting

- **AWS Free Tier**: EC2 gratis selama 750 jam/bulan untuk 12 bulan pertama.
- **Supabase Free Tier**: Database maksimal 500MB, akan di-pause otomatis jika tidak aktif.
- **SSL/HTTPS**: Sertifikat Let's Encrypt berlaku 90 hari dan di-renew otomatis oleh Certbot setiap 60 hari.
- **File Upload**: File yang diunggah akan tersimpan di local storage EC2 (`storage/app/`). File tidak akan hilang kecuali Anda menghapus instance EC2.
- **Backup**: Supabase melakukan backup harian otomatis pada paket berbayar. Untuk paket gratis, lakukan export manual via `pg_dump`.

---

## 13. Struktur File Deployment

Folder `deploy/` berisi file-file berikut:
```text
deploy/
├── nginx/
│   └── sela-website.conf    # Konfigurasi virtual host Nginx (HTTP, Certbot auto-adds HTTPS)
├── setup-server.sh           # Script setup server (sekali jalan)
├── setup-ssl.sh              # Script setup SSL Let's Encrypt (sekali jalan, setelah deploy)
└── deploy.sh                 # Script deployment rutin (setiap update kode)
```

---

## 14. Urutan Lengkap Setup (Ringkasan)

```bash
# 1. SSH ke EC2
ssh -i "your-key.pem" ubuntu@your-ec2-ip

# 2. Clone repo
sudo git clone https://github.com/YOUR_USERNAME/Sela-Website.git /var/www/sela-website

# 3. Setup server (install PHP, Nginx, Certbot, dll)
sudo bash /var/www/sela-website/deploy/setup-server.sh

# 4. Configure .env
cd /var/www/sela-website
cp .env.example .env
nano .env                    # Edit sesuai kredensial Supabase
php artisan key:generate

# 5. Deploy aplikasi
bash deploy/deploy.sh

# 6. Setup SSL (pastikan domain sudah diarahkan ke IP EC2)
sudo bash deploy/setup-ssl.sh

# 7. Done! API tersedia di:
#    https://dardcor.acalypha.my.id/api
```
