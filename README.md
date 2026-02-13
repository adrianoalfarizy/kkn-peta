# 📍 Sistem Peta Rumah Warga Desa Gunungsari

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind-3.0-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind">
  <img src="https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite" alt="SQLite">
</p>

## 📖 Tentang Proyek

Sistem Informasi Peta Rumah Warga adalah aplikasi web untuk mengelola dan memvisualisasikan data lokasi rumah warga **Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto**.

Dikembangkan oleh Tim KKN untuk membantu perangkat desa dalam:
- 🗺️ Visualisasi sebaran rumah warga di peta interaktif
- 📊 Manajemen data lokasi rumah
- 🔍 Pencarian dan filter berdasarkan radius
- 📥 Import/Export data CSV
- 🔐 Sistem keamanan dengan autentikasi admin

## ✨ Fitur Utama

- ✅ **CRUD Data Rumah** - Tambah, edit, hapus data rumah dengan mudah
- 🗺️ **Peta Interaktif** - Visualisasi dengan Leaflet.js dan marker clustering
- 🔍 **Pencarian & Filter** - Cari berdasarkan alamat atau radius lokasi
- 📤 **Export CSV** - Backup data untuk analisis di Excel/Google Sheets
- 📥 **Import CSV** - Upload data massal dari file CSV
- 🔐 **Autentikasi Admin** - Proteksi data dengan sistem login
- 🎨 **UI Modern** - Desain responsive dengan Tailwind CSS
- 🔔 **Toast Notification** - Feedback interaktif untuk setiap aksi
- 📱 **Mobile Friendly** - Dapat diakses dari smartphone

## 🚀 Quick Start

### Kebutuhan Sistem
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite (sudah include)

### Instalasi

```bash
# Clone repository
git clone [repository-url]
cd kkn-peta

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed --class=AdminSeeder

# Build assets
npm run build

# Jalankan server
php artisan serve
```

Akses di browser: `http://localhost:8000`

## 🔐 Login Admin

**Email:** admin@gunungsari.id  
**Password:** Gunungsari@2025!Secure

⚠️ **WAJIB ganti password setelah login pertama untuk keamanan!**

## 📚 Dokumentasi

- 📖 **[PANDUAN_KELURAHAN.md](PANDUAN_KELURAHAN.md)** - Panduan lengkap untuk pengguna kelurahan
- 🔐 **[INFORMASI_AKSES.md](INFORMASI_AKSES.md)** - Kredensial dan kontak support
- ✅ **[CHECKLIST_DEPLOYMENT.md](CHECKLIST_DEPLOYMENT.md)** - Checklist sebelum serah terima
- 📄 **[BERITA_ACARA_SERAH_TERIMA.md](BERITA_ACARA_SERAH_TERIMA.md)** - Template berita acara resmi

## 💾 Backup Database

### Windows
Double-click file `backup-database.bat`

### Manual
Copy file `database/database.sqlite` ke lokasi aman

## 🛠️ Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** SQLite
- **Maps:** Leaflet.js + OpenStreetMap
- **Clustering:** Leaflet.markercluster

## 📸 Screenshot

[Tambahkan screenshot aplikasi di sini]

## 🤝 Kontribusi

Proyek ini dikembangkan oleh Tim KKN untuk Kelurahan Gunungsari.

## 📞 Support

Untuk bantuan teknis atau pertanyaan:
- **Email:** [email-support]
- **WhatsApp:** [nomor-wa]

## 📄 Lisensi

Hak cipta © 2025 Tim KKN - Kelurahan Gunungsari  
Seluruh data adalah milik Kelurahan Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto.

## ⚠️ Disclaimer

- Koordinat GPS bersifat estimasi
- Data hanya untuk keperluan administrasi kelurahan
- Dilarang menyebarluaskan data tanpa izin resmi
- Lakukan backup data secara rutin

---

**Dikembangkan dengan ❤️ oleh Tim KKN untuk Desa Gunungsari**
