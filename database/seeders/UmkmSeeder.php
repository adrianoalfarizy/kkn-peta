<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $umkms = [
            [
                'nama_usaha' => 'Warung Makan Bu Sari',
                'pemilik' => 'Sari Wulandari',
                'kategori' => 'kuliner',
                'alamat' => 'Jl. Raya Gunungsari No. 15, RT 02/RW 01',
                'latitude' => -7.4521,
                'longitude' => 112.6234,
                'kontak' => '081234567890',
                'jam_operasional' => '06:00 - 21:00',
                'deskripsi' => 'Warung makan dengan menu masakan rumahan, nasi gudeg, dan aneka lauk pauk tradisional.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Toko Kelontong Berkah',
                'pemilik' => 'Ahmad Fauzi',
                'kategori' => 'retail',
                'alamat' => 'Jl. Masjid No. 8, RT 01/RW 02',
                'latitude' => -7.4535,
                'longitude' => 112.6245,
                'kontak' => '082345678901',
                'jam_operasional' => '05:30 - 22:00',
                'deskripsi' => 'Toko kelontong lengkap dengan kebutuhan sehari-hari, sembako, dan perlengkapan rumah tangga.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Salon Cantik Indah',
                'pemilik' => 'Indah Permatasari',
                'kategori' => 'jasa',
                'alamat' => 'Jl. Pemuda No. 22, RT 03/RW 01',
                'latitude' => -7.4518,
                'longitude' => 112.6251,
                'kontak' => '083456789012',
                'jam_operasional' => '08:00 - 17:00',
                'deskripsi' => 'Salon kecantikan dengan layanan potong rambut, creambath, facial, dan perawatan kecantikan lainnya.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Bengkel Motor Jaya',
                'pemilik' => 'Joko Susilo',
                'kategori' => 'jasa',
                'alamat' => 'Jl. Industri No. 5, RT 04/RW 02',
                'latitude' => -7.4542,
                'longitude' => 112.6228,
                'kontak' => '084567890123',
                'jam_operasional' => '07:00 - 18:00',
                'deskripsi' => 'Bengkel motor dengan layanan service, ganti oli, dan perbaikan motor semua merk.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Tani Organik Sejahtera',
                'pemilik' => 'Budi Santoso',
                'kategori' => 'pertanian',
                'alamat' => 'Jl. Sawah Baru No. 12, RT 05/RW 03',
                'latitude' => -7.4558,
                'longitude' => 112.6212,
                'kontak' => '085678901234',
                'jam_operasional' => '05:00 - 17:00',
                'deskripsi' => 'Usaha pertanian organik dengan produk sayuran segar, beras organik, dan pupuk kompos.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Kerajinan Bambu Kreatif',
                'pemilik' => 'Siti Nurhaliza',
                'kategori' => 'kerajinan',
                'alamat' => 'Jl. Kerajinan No. 18, RT 02/RW 03',
                'latitude' => -7.4525,
                'longitude' => 112.6267,
                'kontak' => '086789012345',
                'jam_operasional' => '08:00 - 16:00',
                'deskripsi' => 'Kerajinan tangan dari bambu seperti tas, tempat pensil, hiasan dinding, dan souvenir unik.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Warung Kopi Santai',
                'pemilik' => 'Andi Wijaya',
                'kategori' => 'kuliner',
                'alamat' => 'Jl. Pasar No. 3, RT 01/RW 01',
                'latitude' => -7.4512,
                'longitude' => 112.6241,
                'kontak' => '087890123456',
                'jam_operasional' => '15:00 - 23:00',
                'deskripsi' => 'Warung kopi dengan suasana santai, menyediakan kopi lokal, teh, dan cemilan tradisional.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Laundry Express',
                'pemilik' => 'Rina Marlina',
                'kategori' => 'jasa',
                'alamat' => 'Jl. Bersih No. 7, RT 03/RW 02',
                'latitude' => -7.4548,
                'longitude' => 112.6258,
                'kontak' => '088901234567',
                'jam_operasional' => '07:00 - 20:00',
                'deskripsi' => 'Jasa laundry kiloan dan satuan dengan layanan antar jemput gratis untuk wilayah desa.',
                'status' => 'aktif',
                'status_verifikasi' => 'menunggu',
            ],
            [
                'nama_usaha' => 'Toko Bangunan Maju',
                'pemilik' => 'Hendra Gunawan',
                'kategori' => 'retail',
                'alamat' => 'Jl. Pembangunan No. 25, RT 04/RW 01',
                'latitude' => -7.4565,
                'longitude' => 112.6275,
                'kontak' => '089012345678',
                'jam_operasional' => '06:00 - 18:00',
                'deskripsi' => 'Toko material bangunan lengkap dengan semen, besi, cat, dan perlengkapan konstruksi.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
            [
                'nama_usaha' => 'Catering Ibu Rumah',
                'pemilik' => 'Dewi Sartika',
                'kategori' => 'kuliner',
                'alamat' => 'Jl. Dapur No. 11, RT 05/RW 02',
                'latitude' => -7.4532,
                'longitude' => 112.6289,
                'kontak' => '081123456789',
                'jam_operasional' => '24 Jam (Pre-order)',
                'deskripsi' => 'Jasa catering untuk acara keluarga, arisan, dan event dengan menu masakan tradisional dan modern.',
                'status' => 'aktif',
                'status_verifikasi' => 'disetujui',
            ],
        ];

        foreach ($umkms as $umkm) {
            Umkm::create($umkm);
        }
    }
}