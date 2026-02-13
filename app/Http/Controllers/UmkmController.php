<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class UmkmController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Umkm::query()->latest();

        // Search
        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function($query) use ($q) {
                $query->where('nama_usaha', 'like', "%{$q}%")
                      ->orWhere('pemilik', 'like', "%{$q}%")
                      ->orWhere('alamat', 'like', "%{$q}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by verification status
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        $collection = $query->get();

        // Radius filter
        if ($request->filled('center_lat') && $request->filled('center_lng') && $request->filled('radius_km')) {
            $centerLat = (float) $request->input('center_lat');
            $centerLng = (float) $request->input('center_lng');
            $radiusKm = (float) $request->input('radius_km');
            
            $collection = $collection->filter(function ($umkm) use ($centerLat, $centerLng, $radiusKm) {
                $dLat = deg2rad((float) $umkm->latitude - $centerLat);
                $dLng = deg2rad((float) $umkm->longitude - $centerLng);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($centerLat)) * cos(deg2rad((float) $umkm->latitude)) * sin($dLng / 2) * sin($dLng / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $distanceKm = 6371 * $c;
                return $distanceKm <= $radiusKm;
            });
        }

        // Pagination
        $perPage = 10;
        $page = (int) ($request->input('page', 1));
        $items = $collection->forPage($page, $perPage)->values();
        $umkms = new LengthAwarePaginator($items, $collection->count(), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Map points
        $points = $items->map(function ($umkm) {
            return [
                'id' => $umkm->id,
                'nama_usaha' => $umkm->nama_usaha,
                'pemilik' => $umkm->pemilik,
                'kategori' => $umkm->kategori_label,
                'alamat' => $umkm->alamat,
                'lat' => (float) $umkm->latitude,
                'lng' => (float) $umkm->longitude,
                'kontak' => $umkm->kontak ?: 'Tidak ada',
                'jam_operasional' => $umkm->jam_operasional ?: 'Tidak diketahui',
                'status' => $umkm->status_label,
                'type' => 'umkm'
            ];
        });

        $categories = [
            'kuliner' => 'Kuliner',
            'retail' => 'Retail/Toko',
            'jasa' => 'Jasa',
            'pertanian' => 'Pertanian',
            'kerajinan' => 'Kerajinan',
            'lainnya' => 'Lainnya'
        ];

        return view('umkms.index', compact('umkms', 'points', 'categories'));
    }

    public function create()
    {
        $categories = [
            'kuliner' => 'Kuliner',
            'retail' => 'Retail/Toko',
            'jasa' => 'Jasa',
            'pertanian' => 'Pertanian',
            'kerajinan' => 'Kerajinan',
            'lainnya' => 'Lainnya'
        ];

        return view('umkms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|in:kuliner,retail,jasa,pertanian,kerajinan,lainnya',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kontak' => 'nullable|string|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status' => 'nullable|in:aktif,tidak_aktif,tutup',
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'aktif';
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($data);

        return redirect()->route('umkms.index')->with('status', 'Data UMKM berhasil ditambahkan!');
    }

    public function show(Umkm $umkm)
    {
        return view('umkms.show', compact('umkm'));
    }

    public function edit(Umkm $umkm)
    {
        $categories = [
            'kuliner' => 'Kuliner',
            'retail' => 'Retail/Toko',
            'jasa' => 'Jasa',
            'pertanian' => 'Pertanian',
            'kerajinan' => 'Kerajinan',
            'lainnya' => 'Lainnya'
        ];

        return view('umkms.edit', compact('umkm', 'categories'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|in:kuliner,retail,jasa,pertanian,kerajinan,lainnya',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kontak' => 'nullable|string|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status' => 'nullable|in:aktif,tidak_aktif,tutup',
            'status_verifikasi' => 'nullable|in:menunggu,disetujui,ditolak',
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'aktif';
        }

        if ($request->hasFile('foto')) {
            if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($data);

        return redirect()->route('umkms.index')->with('status', 'Data UMKM berhasil diperbarui!');
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
            Storage::disk('public')->delete($umkm->foto);
        }
        
        $umkm->delete();

        return redirect()->route('umkms.index')->with('status', 'Data UMKM berhasil dihapus!');
    }

    public function export()
    {
        $filename = 'umkm.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'nama_usaha', 'pemilik', 'kategori', 'alamat', 'latitude', 'longitude', 'kontak', 'jam_operasional', 'status', 'created_at']);
            
            Umkm::orderBy('id')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, [
                        $row->id,
                        $row->nama_usaha,
                        $row->pemilik,
                        $row->kategori,
                        $row->alamat,
                        $row->latitude,
                        $row->longitude,
                        $row->kontak,
                        $row->jam_operasional,
                        $row->status,
                        $row->created_at,
                    ]);
                }
            });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel',
        ]);

        $file = $request->file('csv');
        $path = $file->getRealPath();
        $inserted = 0;

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle, 0, ',');
            $isHeader = false;
            
            if ($header && count($header) >= 6) {
                $lower = array_map('strtolower', $header);
                $isHeader = in_array('nama_usaha', $lower) && in_array('latitude', $lower) && in_array('longitude', $lower);
            } else {
                rewind($handle);
            }

            if (!$isHeader) {
                rewind($handle);
            }

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if ($isHeader) {
                    $map = array_flip(array_map('strtolower', $header));
                    $namaUsaha = $row[$map['nama_usaha']] ?? null;
                    $pemilik = $row[$map['pemilik']] ?? null;
                    $kategori = $row[$map['kategori']] ?? 'lainnya';
                    $alamat = $row[$map['alamat']] ?? null;
                    $lat = $row[$map['latitude']] ?? null;
                    $lng = $row[$map['longitude']] ?? null;
                    $kontak = $row[$map['kontak']] ?? null;
                } else {
                    $namaUsaha = $row[0] ?? null;
                    $pemilik = $row[1] ?? null;
                    $kategori = $row[2] ?? 'lainnya';
                    $alamat = $row[3] ?? null;
                    $lat = $row[4] ?? null;
                    $lng = $row[5] ?? null;
                    $kontak = $row[6] ?? null;
                }

                if ($namaUsaha === null || $pemilik === null || $alamat === null || $lat === null || $lng === null) {
                    continue;
                }

                $latStr = str_replace(',', '.', trim((string) $lat));
                $lngStr = str_replace(',', '.', trim((string) $lng));
                $latF = (float) $latStr;
                $lngF = (float) $lngStr;
                if (abs($latF) > 90 && abs($lngF) <= 90) {
                    [$latF, $lngF] = [$lngF, $latF];
                }
                
                if (!is_finite($latF) || !is_finite($lngF)) {
                    continue;
                }

                Umkm::create([
                    'nama_usaha' => $namaUsaha,
                    'pemilik' => $pemilik,
                    'kategori' => in_array($kategori, ['kuliner', 'retail', 'jasa', 'pertanian', 'kerajinan', 'lainnya']) ? $kategori : 'lainnya',
                    'alamat' => $alamat,
                    'latitude' => $latF,
                    'longitude' => $lngF,
                    'kontak' => $kontak,
                ]);
                $inserted++;
            }
            fclose($handle);
        }

        return redirect()->route('umkms.index')->with('status', "Import berhasil: {$inserted} data UMKM ditambahkan");
    }
}
