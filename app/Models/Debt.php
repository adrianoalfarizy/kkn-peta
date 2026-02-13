<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'jenis_subsidi',
        'deskripsi',
        'jumlah_utang',
        'jumlah_dibayar',
        'status',
        'tanggal_utang',
        'jatuh_tempo',
        'catatan',
    ];

    protected $casts = [
        'jumlah_utang' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'tanggal_utang' => 'date',
        'jatuh_tempo' => 'date',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function getSisaUtangAttribute()
    {
        return $this->jumlah_utang - $this->jumlah_dibayar;
    }

    public function getPersentaseLunasAttribute()
    {
        if ($this->jumlah_utang == 0) return 0;
        return ($this->jumlah_dibayar / $this->jumlah_utang) * 100;
    }

    public function getJenisSubsidiLabelAttribute()
    {
        return match($this->jenis_subsidi) {
            'pupuk' => 'Pupuk',
            'bibit' => 'Bibit',
            'alat_pertanian' => 'Alat Pertanian',
            'lainnya' => 'Lainnya',
            default => $this->jenis_subsidi
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'belum_lunas' => 'Belum Lunas',
            'lunas' => 'Lunas',
            'menunggak' => 'Menunggak',
            default => $this->status
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'belum_lunas' => 'yellow',
            'lunas' => 'green',
            'menunggak' => 'red',
            default => 'gray'
        };
    }
}