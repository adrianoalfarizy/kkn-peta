<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\Resident;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have houses first
        if (House::count() === 0) {
            House::create([
                'alamat' => 'Jl. Raya Gunungsari No. 1',
                'no_kk' => '3517010101010001',
                'latitude' => -7.5665,
                'longitude' => 112.4326,
            ]);
            
            House::create([
                'alamat' => 'Jl. Masjid Gunungsari No. 15',
                'no_kk' => '3517010101010002',
                'latitude' => -7.5670,
                'longitude' => 112.4330,
            ]);
        }

        $houses = House::all();
        
        if ($houses->count() < 2) {
            House::create([
                'alamat' => 'Jl. Masjid Gunungsari No. 15',
                'no_kk' => '3517010101010002',
                'latitude' => -7.5670,
                'longitude' => 112.4330,
            ]);
            $houses = House::all();
        }
        
        $residents = [
            [
                'house_id' => $houses->first()->id,
                'nik' => '3517010101850001',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-05-15',
                'tempat_lahir' => 'Mojokerto',
                'status_keluarga' => 'kepala',
                'status_kawin' => 'kawin',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Petani',
                'status_ekonomi' => 'miskin',
                'penerima_pkh' => true,
                'penerima_bpnt' => true,
                'penerima_blt' => false,
                'no_hp' => '081234567890',
            ],
            [
                'house_id' => $houses->first()->id,
                'nik' => '3517010101900002',
                'nama' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-08-20',
                'tempat_lahir' => 'Mojokerto',
                'status_keluarga' => 'istri',
                'status_kawin' => 'kawin',
                'agama' => 'Islam',
                'pendidikan' => 'SMP',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'status_ekonomi' => 'miskin',
                'penerima_pkh' => true,
                'penerima_bpnt' => true,
                'penerima_blt' => false,
                'no_hp' => '081234567891',
            ],
            [
                'house_id' => $houses->first()->id,
                'nik' => '3517010101150003',
                'nama' => 'Ahmad Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2015-03-10',
                'tempat_lahir' => 'Mojokerto',
                'status_keluarga' => 'anak',
                'status_kawin' => 'belum_kawin',
                'agama' => 'Islam',
                'pendidikan' => 'SD',
                'pekerjaan' => null,
                'status_ekonomi' => 'miskin',
                'penerima_pkh' => false,
                'penerima_bpnt' => false,
                'penerima_blt' => false,
                'no_hp' => null,
            ],
            [
                'house_id' => $houses->skip(1)->first()->id,
                'nik' => '3517010101800004',
                'nama' => 'Joko Widodo',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1980-12-05',
                'tempat_lahir' => 'Mojokerto',
                'status_keluarga' => 'kepala',
                'status_kawin' => 'kawin',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Wiraswasta',
                'status_ekonomi' => 'tidak_miskin',
                'penerima_pkh' => false,
                'penerima_bpnt' => false,
                'penerima_blt' => false,
                'no_hp' => '081234567892',
            ],
            [
                'house_id' => $houses->skip(1)->first()->id,
                'nik' => '3517010101850005',
                'nama' => 'Mega Sari',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1985-07-18',
                'tempat_lahir' => 'Surabaya',
                'status_keluarga' => 'istri',
                'status_kawin' => 'kawin',
                'agama' => 'Islam',
                'pendidikan' => 'D3',
                'pekerjaan' => 'Guru',
                'status_ekonomi' => 'tidak_miskin',
                'penerima_pkh' => false,
                'penerima_bpnt' => false,
                'penerima_blt' => false,
                'no_hp' => '081234567893',
            ],
        ];

        foreach ($residents as $residentData) {
            Resident::create($residentData);
        }
    }
}