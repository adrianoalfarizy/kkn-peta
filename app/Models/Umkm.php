<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{

    protected $fillable = [
        'nama_usaha',
        'pemilik',
        'kategori',
        'alamat',
        'latitude',
        'longitude',
        'kontak',
        'jam_operasional',
        'deskripsi',
        'foto',
        'status',
        'status_verifikasi',
    ];

    public function getKategoriLabelAttribute()
    {
        $labels = [
            'kuliner' => 'Kuliner',
            'retail' => 'Retail/Toko',
            'jasa' => 'Jasa',
            'pertanian' => 'Pertanian',
            'kerajinan' => 'Kerajinan',
            'lainnya' => 'Lainnya'
        ];
        
        return $labels[$this->kategori] ?? $this->kategori;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'tutup' => 'Tutup'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusVerifikasiLabelAttribute()
    {
        $labels = [
            'menunggu' => 'Menunggu Verifikasi',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak'
        ];
        
        return $labels[$this->status_verifikasi] ?? $this->status_verifikasi;
    }
}