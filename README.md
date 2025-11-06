# 📧 Sistem Absensi PT. Mada Wikri Tunggal

Sistem absensi berbasis web dengan QR Code untuk PT. Mada Wikri Tunggal. Aplikasi ini memungkinkan pengelolaan data karyawan, pengiriman undangan email dengan QR Code embedded, dan sistem absensi yang efisien.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## ✨ Fitur Utama

### 🎯 Manajemen Data
- **Manajemen Departemen** - Kelola data departemen perusahaan
- **Manajemen Plant** - Kelola data plant/lokasi perusahaan
- **Manajemen Karyawan** - CRUD lengkap untuk data karyawan
  - Import data karyawan dari Excel/CSV
  - Template import tersedia
  - Validasi data otomatis
- **Manajemen Pengguna** - Kelola akun admin
- **Manajemen Absen** - Lihat dan kelola data absensi

### 📧 Sistem Email dengan QR Code
- **Kirim Undangan Email** - Kirim undangan seminar ke karyawan
- **QR Code Embedded** - QR Code langsung muncul di body email (bukan cuma attachment)
- **Background Processing** - Email dikirim menggunakan Laravel Queue (non-blocking)
- **Mobile Responsive Email** - Email template yang rapi di desktop dan mobile
- **Batch & Individual Send** - Kirim email ke semua karyawan atau satu per satu

### 📱 Sistem Absensi
- **QR Code Scanning** - Absensi menggunakan QR Code yang dikirim via email
- **NIK Input** - Alternatif input NIK jika QR Code tidak bisa di-scan
- **Sound Feedback** - Audio feedback saat absensi berhasil/gagal
- **Real-time Validation** - Validasi absensi real-time

### 🎨 Admin Panel
- **Dashboard** - Overview data dan statistik
- **Modern UI** - Interface yang modern dan user-friendly
- **Responsive Design** - Bisa diakses dari desktop dan mobile

## 🛠️ Tech Stack

- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **QR Code**: 
  - `endroid/qr-code` (v5.0)
  - `simplesoftwareio/simple-qrcode` (v4.2)
- **Excel Import**: `phpoffice/phpspreadsheet`
- **Email**: Laravel Mailer dengan Queue
- **Queue**: Laravel Queue (Database Driver)

## 📋 Requirements

- PHP >= 8.2
- Composer
- SQLite (default) atau MySQL/PostgreSQL
- Extension PHP:
  - `ext-zip` (untuk PhpSpreadsheet)
  - `ext-mbstring`
  - `ext-openssl`
  - `ext-pdo`
  - `ext-tokenizer`

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/ardyansyahp/etiket.git
cd etiket
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=sqlite
# atau untuk MySQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=etiket
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Setup Storage

```bash
php artisan storage:link
```

## ⚙️ Konfigurasi

### Konfigurasi Email

Edit file `.env` untuk mengatur email SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Catatan untuk Gmail:**
- Gunakan App Password, bukan password biasa
- Aktifkan 2-Step Verification terlebih dahulu
- Generate App Password di: https://myaccount.google.com/apppasswords

### Konfigurasi Queue

Queue sudah dikonfigurasi untuk menggunakan database driver. Pastikan tabel `jobs` sudah dibuat:

```bash
php artisan migrate
```

## 🎯 Cara Penggunaan

### 1. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

### 2. Login Admin

- Akses: `http://localhost:8000/admin/login`
- Login menggunakan kredensial admin yang sudah dibuat

### 3. Setup Data Karyawan

#### A. Manual Input
1. Buka menu **Karyawan**
2. Klik **Tambah Karyawan**
3. Isi form data karyawan
4. Pastikan email sudah diisi (untuk kirim undangan)

#### B. Import Excel/CSV
1. Buka menu **Karyawan**
2. Klik **Download Template** untuk mendapatkan template
3. Isi template dengan data karyawan
4. Klik **Import Excel** dan pilih file
5. Sistem akan validasi dan import data otomatis

**Format Template:**
- File: `.xlsx`, `.xls`, atau `.csv`
- Header: `nik`, `nama_lengkap`, `email`, `no_telp`, `tanggal_masuk`, dll
- Encoding: UTF-8

### 4. Kirim Undangan Email

#### A. Kirim ke Semua Karyawan
1. Buka menu **Karyawan**
2. Klik tombol **📧 Kirim Undangan ke Semua**
3. Email akan masuk ke queue dan dikirim di background

#### B. Kirim ke Satu Karyawan
1. Buka menu **Karyawan**
2. Klik tombol **📧** pada baris karyawan yang ingin dikirim email
3. Email akan masuk ke queue dan dikirim di background

### 5. Jalankan Queue Worker

**PENTING**: Queue worker harus berjalan untuk memproses email!

```bash
# Windows
php artisan queue:work

# Atau gunakan batch file
run-queue.bat

# Linux/Mac
php artisan queue:work
```

**Untuk Production:**
Gunakan Supervisor atau systemd untuk auto-restart queue worker:

```bash
# Supervisor example
[program:etiket-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/etiket/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/etiket/storage/logs/queue.log
```

### 6. Sistem Absensi

- Akses: `http://localhost:8000`
- Karyawan bisa scan QR Code atau input NIK
- Sistem akan validasi dan mencatat absensi

## 📁 Struktur Project

```
etiket/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AbsenController.php    # Controller untuk absensi
│   │   │   └── AdminController.php     # Controller untuk admin panel
│   │   └── Middleware/
│   ├── Mail/
│   │   └── UndanganAbsen.php          # Mailable class untuk email undangan
│   └── Models/
│       ├── Absen.php
│       ├── Departemen.php
│       ├── Karyawan.php
│       ├── Pengguna.php
│       └── Plant.php
├── database/
│   ├── migrations/                      # Database migrations
│   └── seeders/
├── public/
│   ├── css/                             # CSS files
│   ├── images/                          # Images & favicon
│   ├── js/                              # JavaScript files
│   └── sound/                           # Audio files untuk feedback
├── resources/
│   └── views/
│       ├── admin/                       # Views untuk admin panel
│       ├── absen/                        # Views untuk absensi
│       └── emails/
│           └── undangan_absen.blade.php # Email template
├── routes/
│   └── web.php                          # Web routes
├── config/
│   ├── mail.php                         # Mail configuration
│   └── queue.php                        # Queue configuration
└── run-queue.bat                         # Helper script untuk queue worker
```

## 🔧 Troubleshooting

### Email Tidak Terkirim

1. **Cek Queue Worker**
   - Pastikan queue worker sedang berjalan
   - Cek log: `storage/logs/laravel.log`

2. **Cek Konfigurasi Email**
   - Pastikan SMTP setting benar di `.env`
   - Untuk Gmail, gunakan App Password

3. **Cek Failed Jobs**
   ```bash
   php artisan queue:failed
   ```

### QR Code Tidak Muncul di Email

- Pastikan menggunakan CID embedding (bukan base64)
- Beberapa email client mungkin memblokir inline images
- QR Code tetap dilampirkan sebagai attachment untuk backup

### Import Excel Gagal

1. **Cek Extension PHP**
   ```bash
   php -m | grep zip
   ```
   Jika tidak ada, aktifkan di `php.ini`:
   ```ini
   extension=zip
   ```

2. **Cek Format File**
   - Pastikan file adalah `.xlsx`, `.xls`, atau `.csv`
   - Pastikan encoding UTF-8
   - Pastikan header sesuai template

3. **Cek Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Queue Worker Tidak Berjalan

1. **Cek Database**
   ```bash
   php artisan migrate
   ```

2. **Cek Permission**
   - Pastikan folder `storage/` dan `bootstrap/cache/` writable

3. **Restart Queue Worker**
   ```bash
   php artisan queue:restart
   php artisan queue:work
   ```

## 📝 Notes

- **Email Queue**: Email menggunakan Laravel Queue untuk background processing. Queue worker harus selalu berjalan.
- **QR Code**: QR Code di-generate dari NIK karyawan dan di-embed langsung di body email menggunakan CID (Content-ID).
- **Mobile Responsive**: Email template sudah dioptimalkan untuk mobile dengan media query.
- **Database**: Default menggunakan SQLite, bisa diubah ke MySQL/PostgreSQL di `.env`.

## 👥 Author

**Ardyansyah Putra**
- Email: ardyansyahputra174@gmail.com
- GitHub: [@ardyansyahp](https://github.com/ardyansyahp)

## 📄 License

MIT License - lihat file [LICENSE](LICENSE) untuk detail lengkap.

## 🙏 Acknowledgments

- Laravel Framework
- Endroid QR Code Library
- PhpSpreadsheet
- PT. Mada Wikri Tunggal

---

**Dibuat dengan ❤️ untuk PT. Mada Wikri Tunggal**
