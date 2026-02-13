# 📍 Panduan Sistem Peta Rumah Warga Desa Gunungsari

## 🎯 Tentang Sistem

Sistem Peta Rumah Warga adalah aplikasi web untuk mengelola data lokasi rumah warga Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto. Sistem ini membantu perangkat desa dalam:

- 📊 Visualisasi sebaran rumah warga di peta interaktif
- 🔍 Pencarian dan filter data berdasarkan lokasi
- 📥 Import/Export data dalam format CSV
- 🗺️ Analisis radius dan jarak antar lokasi

---

## 🔐 Login Admin

### Akun Default
- **Email:** `admin@gunungsari.id`
- **Password:** `password123`

⚠️ **PENTING:** Segera ganti password setelah login pertama kali!

### Cara Login
1. Buka website
2. Klik tombol "Login" di pojok kanan atas
3. Masukkan email dan password
4. Klik "Login"

---

## 📝 Cara Menggunakan Sistem

### 1. Menambah Data Rumah Baru

1. Login sebagai admin
2. Klik tombol "Tambah Rumah"
3. Isi alamat rumah (minimal 5 karakter)
4. **Klik pada peta** untuk menentukan lokasi rumah
5. Koordinat latitude dan longitude akan terisi otomatis
6. Klik "Simpan"

💡 **Tips:** Zoom peta untuk akurasi lokasi yang lebih baik

### 2. Mengedit Data Rumah

1. Pada tabel data, klik tombol "Edit" pada rumah yang ingin diubah
2. Ubah alamat atau klik peta untuk mengubah lokasi
3. Klik "Update"

### 3. Menghapus Data Rumah

1. Pada tabel data, klik tombol "Hapus"
2. Konfirmasi penghapusan
3. Data akan terhapus permanen

⚠️ **Perhatian:** Data yang dihapus tidak dapat dikembalikan!

### 4. Mencari Data Rumah

**Pencarian Alamat:**
- Ketik alamat di kolom pencarian
- Klik "Cari"

**Filter Radius:**
1. Isi Center Lat dan Center Lng (atau klik "Gunakan Titik Peta")
2. Isi Radius dalam kilometer
3. Klik "Terapkan"
4. Sistem akan menampilkan rumah dalam radius tersebut

### 5. Export Data (Backup)

1. Klik tombol "Ekspor CSV"
2. File akan terdownload otomatis
3. Simpan file sebagai backup

📅 **Rekomendasi:** Lakukan backup minimal 1 bulan sekali

### 6. Import Data dari CSV

**Format File CSV:**
```
alamat,latitude,longitude
Jl. Raya Gunungsari No. 1,-7.123456,112.654321
Jl. Mawar No. 5,-7.123789,112.654987
```

**Cara Import:**
1. Siapkan file CSV dengan format di atas
2. Scroll ke bawah halaman
3. Klik "Choose File" dan pilih file CSV
4. Klik "Import"
5. Tunggu proses selesai

💡 **Tips:** Baris pertama boleh berisi header (alamat, latitude, longitude)

---

## 🛠️ Instalasi & Setup (Untuk IT/Developer)

### Kebutuhan Sistem
- PHP 8.2 atau lebih tinggi
- Composer
- SQLite (sudah include)
- Node.js & NPM (untuk build assets)

### Langkah Instalasi

1. **Clone/Copy project ke server**

2. **Install dependencies:**
```bash
composer install
npm install
```

3. **Setup environment:**
```bash
copy .env.example .env
php artisan key:generate
```

4. **Setup database:**
```bash
php artisan migrate
php artisan db:seed
```

5. **Build assets:**
```bash
npm run build
```

6. **Jalankan server:**
```bash
php artisan serve
```

7. **Akses di browser:**
```
http://localhost:8000
```

---

## 🔒 Keamanan

### Ganti Password Admin

1. Login sebagai admin
2. (Fitur ganti password akan ditambahkan)
3. Sementara, hubungi developer untuk ganti password

### Backup Database

**Manual Backup:**
1. Copy file `database/database.sqlite`
2. Simpan di lokasi aman dengan nama: `backup-YYYY-MM-DD.sqlite`

**Restore Backup:**
1. Stop aplikasi
2. Replace file `database/database.sqlite` dengan file backup
3. Jalankan kembali aplikasi

---

## ⚠️ Disclaimer & Kebijakan

### Kepemilikan Data
Seluruh data dalam sistem ini adalah milik **Kelurahan Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto**.

### Penggunaan Data
- Data hanya untuk keperluan administrasi kelurahan
- Dilarang menyebarluaskan tanpa izin resmi
- Dilarang menggunakan untuk kepentingan komersial

### Keamanan
- Jaga kerahasiaan akun login
- Jangan share password ke pihak tidak berwenang
- Logout setelah selesai menggunakan sistem

### Akurasi Data
- Koordinat GPS bersifat estimasi
- Untuk keperluan legal, verifikasi ke lapangan
- Kelurahan tidak bertanggung jawab atas kesalahan data

---

## 📞 Kontak Support

Untuk bantuan teknis atau pertanyaan:

- **Tim KKN:** [Kontak Tim KKN]
- **IT Kelurahan:** [Kontak IT]
- **Email:** admin@gunungsari.id

---

## 📋 Troubleshooting

### Tidak Bisa Login
- Pastikan email dan password benar
- Cek koneksi internet
- Clear cache browser (Ctrl+F5)

### Peta Tidak Muncul
- Cek koneksi internet
- Refresh halaman (F5)
- Coba browser lain (Chrome/Firefox)

### Import CSV Gagal
- Pastikan format CSV benar
- Cek tidak ada data kosong
- Pastikan koordinat valid (angka desimal)

### Data Hilang
- Restore dari backup terakhir
- Hubungi IT support

---

## 📚 Fitur Mendatang (Roadmap)

- [ ] Ganti password admin
- [ ] Role management (admin, viewer)
- [ ] Kategori rumah (layak huni, tidak layak)
- [ ] Upload foto rumah
- [ ] Data kepala keluarga
- [ ] Heatmap kepadatan
- [ ] Export PDF/Excel
- [ ] Notifikasi email
- [ ] Log aktivitas admin
- [ ] Backup otomatis

---

## 📄 Lisensi

Sistem ini dikembangkan oleh Tim KKN untuk Kelurahan Gunungsari.
Hak cipta dilindungi undang-undang.

---

**Terakhir diupdate:** Januari 2025
**Versi:** 1.0.0
