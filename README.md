# saldohub

Fitur utama:

- Halaman publik: landing page, layanan top up, layanan jasa bayar, blog, kontak, halaman statis (kebijakan privasi, syarat & ketentuan, cara order)
- Kalkulator simulasi harga (rate x nominal, admin fee 4% min Rp 30.000) via AJAX ke `GET /api/simulate`
- Akun pengguna: daftar, masuk, keluar (password_hash, CSRF, filter `auth`)
- Dashboard: riwayat order, order **Top Up** (min. $30), order **Jasa Bayar** (min. $5), detail order + instruksi pembayaran bank, tombol konfirmasi WhatsApp, halaman profil
- **Generate PDF invoice** per order (Dompdf) dari halaman detail order — sediakan tombol "Unduh Invoice PDF"
- **Panel admin** (`/admin`, khusus role admin):
  - Upload **bukti pengiriman** langsung dari website (tidak perlu Google Drive lagi): gambar otomatis di-resize maks. 1000px + kompres JPEG kualitas 72 (khasnya < 50 KB/buku bukti, hemat space hosting)
  - Status order otomatis jadi "Selesai" saat bukti diunggah, atau diubah manual (Diproses/Selesai/Batal)
  - **Email notif otomatis** ke pelanggan, berisi lampiran bukti + tombol "Lihat Bukti Pengiriman"
  - Daftar pelanggan + jumlah order per user
  - Bukti tampil juga di halaman detail order pelanggan (dilayani via rute `proof/{id}`, hanya pemilik order & admin)
- Depensi PDF & gambar: `dompdf/dompdf` (ekstensi `dom`, `mbstring`) + ekstensi PHP `gd` untuk kompresi bukti

## Persyaratan

- PHP **8.1+** dengan ekstensi berikut (wajib):
  - `intl`
  - `mbstring`
  - `pdo_sqlite` + `sqlite3` (database default SQLite)
  - `curl`
- Composer 2+

Cek ekstensi yang aktif:

```bash
php -m | grep -Ei "intl|sqlite|mbstring|curl"
```

> Di Ubuntu/Debian, ekstensi bisa dipasang dengan:
> `sudo apt-get install php-intl php-sqlite3 php-curl php-mbstring`

## Cara Menjalankan

1. **Pasang dependensi** (sekali saja, sudah termasuk framework):

   ```bash
   composer install
   ```

2. **Siapkan file environment.** File `.env` sudah disertakan (database SQLite, base URL `http://localhost:8080`). Bila belum ada, salin dari template lalu isi:

   ```bash
   cp env .env
   ```

   Isi `.env` yang dibutuhkan:

   ```ini
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8080'

   database.default.DBDriver = SQLite3
   database.default.database = saldohub.sqlite

   email.fromEmail = 'no-reply@saldohub.test'
   ```

3. **Buat tabel database** (migrasi) dan **data awal** (rate, rekening, nomor WA, akun demo):

   ```bash
   php spark migrate
   php spark db:seed SettingSeed
   php spark db:seed UserSeed
   ```

4. **Jalankan server pengembangan:**

   ```bash
   php spark serve
   ```

   Buka **http://localhost:8080** di peramban.

Jika memakai web server sendiri (Apache/Nginx), arahkan *document root* ke folder `public/`.

## Akun Demo

| Email | Sandi |
|---|---|
| `user@saldohub.test` | `user12345` |

Order yang dibuat akan tampil di dashboard beserta detailnya (nomor order, rate, total rupiah, rekening tujuan).

## Pengaturan Rate & Kontak

Nilai-nilai ini bisa diubah lewat tabel `settings` di database SQLite (`writable/saldohub.sqlite`):

| Kunci | Arti |
|---|---|
| `rate` | Kurs Rp per 1 USD |
| `min_topup_usd` | Nominal minimal top up ($30) |
| `min_pay_usd` | Nominal minimal jasa bayar ($5) |
| `admin_fee_pct` | Persentase biaya admin jasa bayar (4) |
| `admin_fee_min` | Batas minimum biaya admin (Rp 30.000) |
| `whatsapp` | Nomor WhatsApp, internasional tanpa tanda `+` |
| `bank_name` / `bank_account` / `bank_holder` | Rekening tujuan pembayaran |

## Struktur Proyek (bagian aplikasi)

```
app/
├── Controllers/
│   ├── Home.php        # halaman publik
│   ├── Auth.php        # daftar / masuk / keluar
│   ├── Dashboard.php   # order top up, order bayar, profil, invoice PDF
│   └── Api.php         # endpoint /api/simulate (dipakai jQuery)
├── Filters/AuthFilter.php
├── Libraries/Calculator.php  # logika perhitungan rate & admin fee
├── Models/                   # UserModel, OrderModel, SettingModel
├── Database/
│   ├── Migrations/           # users, orders, settings
│   └── Seeds/                # SettingSeed, UserSeed
├── Config/                   # Routes, Filters
└── Views/
    ├── layouts/              # main.php (publik) & dashboard.php
    ├── partials/             # navbar, footer, flash, sim (kartu kalkulator)
    ├── home/                 # index, topup, pay, blog, contact, pages/*
    ├── auth/                 # login, register
    └── dashboard/            # index, order_topup, order_pay, show, invoice_pdf, profile
public/
├── assets/css/style.css      # tema kustom
└── assets/js/app.js          # skrip jQuery (simulasi AJAX, estimasi order)
writable/                     # log, sesi, cache, database SQLite
```

Rute penting:

| URL | Keterangan |
|---|---|
| `/` | Halaman utama |
| `/jasa-top-up-paypal` | Layanan top up |
| `/jasa-pembayaran-paypal` | Layanan jasa bayar |
| `/blog`, `/contact`, `/page/...` | Halaman lain |
| `/login`, `/register`, `/logout` | Akun |
| `/dashboard` | Dashboard (butuh login) |
| `/dashboard/order/1` | Detail order (butuh login) |
| `/dashboard/invoice/1` | Unduh PDF invoice order #1 (butuh login) |
| `/admin` | Panel admin: kelola order, upload bukti (role admin saja) |
| `/admin/pelanggan` | Daftar pelanggan (role admin saja) |
| `/proof/1` | File bukti pengiriman order #1 (pemilik order/admin saja) |

Akun demo admin: `admin@saldohub.test` / `admin12345`.

Untuk aktifkan email notif bukti, isi SMTP di `.env` (baris `email.SMTPHost` sudah disiapkan sebagai komentar). Tanpa SMTP, bukti tetap tersimpan & order selesai — hanya email yang tidak terkirim. Bukti disimpan di `writable/uploads/proofs/`.
| `/api/simulate?type=topup&amount=50` | Endpoint simulasi |

## Masalah Umum

- **Halaman 500 "Invalid session handler"** — hapus baris `session.*` di `.env` agar memakai konfigurasi bawaan `app/Config/Session.php`.
- **"Migrations complete" tapi tabel tidak ada** — nama file migrasi wajib format `YYYY-MM-DD-HHMMSS_NamaKelas.php` (pemisah terakhir garis bawah `_`, bukan `-`).
- **Ekstensi `intl` tidak ada** — CI4 membutuhkannya; pasang lewat `sudo apt-get install php-intl`.
- **Server tidak mau mati** saat `spark serve` — cari proses dengan `ps aux | grep php -S` lalu matikan dengan `kill <pid>`.
