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
```

---

## 2. Prasyarat

Sebelum memulai, pastikan Anda memiliki:
- Akun AWS (bisa menggunakan Free Tier).
- Akun Supabase (Gratis).
- Git terinstall di komputer lokal.
- SSH Key Pair untuk akses EC2.
- Domain (opsional, bisa menggunakan IP Publik EC2).

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

## 5. Part C — Setup Server (SSH ke EC2)

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
   - Mengatur permission folder agar web server bisa menulis file.

---

## 6. Part D — Configure Environment

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
   APP_URL=http://your-ec2-ip
   
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

## 7. Part E — Deploy & Test

1. Jalankan script deploy untuk memastikan semua dependensi terinstall:
   ```bash
   bash /var/www/sela-website/deploy/deploy.sh
   ```

2. Test API dari komputer lokal menggunakan `curl` atau Postman:
   ```bash
   # Register User Baru
   curl -X POST http://YOUR_EC2_IP/api/register \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"username":"testuser","email":"test@test.com","password":"password123"}'
   
   # Login
   curl -X POST http://YOUR_EC2_IP/api/login \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"email":"test@test.com","password":"password123"}'
   ```

3. Verifikasi data telah masuk di **Supabase Dashboard** → **Table Editor** → table `users`.

---

## 8. Part F — Update Deployment (Deploy Ulang)

Jika Anda melakukan perubahan kode di komputer lokal dan sudah push ke GitHub, lakukan langkah ini di server:

```bash
ssh -i "your-key.pem" ubuntu@your-ec2-ip
cd /var/www/sela-website
bash deploy/deploy.sh
```

---

## 9. Troubleshooting

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

---

## 10. Catatan Penting

- **AWS Free Tier**: EC2 gratis selama 750 jam/bulan untuk 12 bulan pertama.
- **Supabase Free Tier**: Database maksimal 500MB, akan di-pause otomatis jika tidak aktif.
- **Produksi**: Untuk penggunaan serius, gunakan connection pooling (port `6543`) dan pasang SSL/HTTPS menggunakan Let's Encrypt.
- **File Upload**: File yang diunggah akan tersimpan di local storage EC2 (`storage/app/`). File tidak akan hilang kecuali Anda menghapus instance EC2.
- **Backup**: Supabase melakukan backup harian otomatis pada paket berbayar. Untuk paket gratis, lakukan export manual via `pg_dump`.

---

## 11. Struktur File Deployment

Folder `deploy/` berisi file-file berikut:
```text
deploy/
├── nginx/
│   └── sela-website.conf    # Konfigurasi virtual host Nginx
├── setup-server.sh           # Script setup server (sekali jalan)
└── deploy.sh                 # Script deployment rutin (setiap update kode)
```
