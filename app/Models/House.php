<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{

    protected $fillable = [
        'alamat',
        'no_kk',
        'foto_kk',
        'latitude',
        'longitude',
        'status',
        'bantuan',
    ];

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function kepalaKeluarga()
    {
        return $this->residents()->where('status_keluarga', 'kepala')->first();
    }

    public function getJumlahPenghuniAttribute()
    {
        return $this->residents()->count();
    }
}