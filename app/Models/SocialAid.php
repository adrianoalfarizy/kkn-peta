<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SocialAid extends Model
{
    protected $fillable = [
        'nama_bantuan', 'jenis_bantuan', 'deskripsi', 'nominal',
        'tanggal_distribusi', 'status', 'target_penerima',
        'realisasi_penerima', 'sumber_dana'
    ];

    protected $casts = [
        'tanggal_distribusi' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Resident::class, 'aid_recipients')
            ->withPivot('status_penerimaan', 'tanggal_terima', 'jumlah_diterima', 'catatan', 'bukti_foto')
            ->withTimestamps();
    }

    public function getPersentaseRealisasiAttribute()
    {
        return $this->target_penerima > 0 ? 
            round(($this->realisasi_penerima / $this->target_penerima) * 100, 2) : 0;
    }
}