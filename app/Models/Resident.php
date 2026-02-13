<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resident extends Model
{

    protected $fillable = [
        'house_id', 'nik', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
        'status_keluarga', 'status_kawin', 'agama', 'pendidikan', 'pekerjaan',
        'status_ekonomi', 'penerima_pkh', 'penerima_bpnt', 'penerima_blt',
        'no_hp', 'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penerima_pkh' => 'boolean',
        'penerima_bpnt' => 'boolean',
        'penerima_blt' => 'boolean',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function socialAids(): BelongsToMany
    {
        return $this->belongsToMany(SocialAid::class, 'aid_recipients')
            ->withPivot('status_penerimaan', 'tanggal_terima', 'jumlah_diterima', 'catatan', 'bukti_foto')
            ->withTimestamps();
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function getTotalUtangAttribute()
    {
        return $this->debts()->sum('jumlah_utang');
    }

    public function getTotalDibayarAttribute()
    {
        return $this->debts()->sum('jumlah_dibayar');
    }

    public function getSisaUtangAttribute()
    {
        return $this->total_utang - $this->total_dibayar;
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    public function getIsKepalaKeluargaAttribute()
    {
        return $this->status_keluarga === 'kepala';
    }
}