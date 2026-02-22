<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HouseController extends BaseController
{

    public function kk(House $house, Request $request)
    {
        // Role gate
        if (!auth()->user()->hasAnyRole(['super_admin', 'admin_desa'])) {
            abort(403);
        }

        if (!$house->foto_kk) {
            abort(404);
        }

        $disk = Storage::disk('secure');
        $path = $house->foto_kk;

        if (!$disk->exists($path)) {
            abort(404);
        }

        // (Opsional tapi recommended) audit log minimal ke laravel.log
        \Log::info('KK accessed', [
            'house_id' => $house->id,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'ua' => substr((string) $request->userAgent(), 0, 180),
        ]);

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';

        // Mode Nginx X-Accel (lebih cepat, private)
        if (env('KK_USE_X_ACCEL', true)) {
            return response('', 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="KK-' . $house->id . '.jpg"',
                'Cache-Control' => 'no-store, private',
                'X-Accel-Redirect' => '/_protected/' . $path,
            ]);
        }

        // Fallback streaming (kalau tidak pakai X-Accel)
        $stream = $disk->readStream($path);
        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream))
                fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Cache-Control' => 'no-store, private',
        ]);
    }

    private function storeKkImageSecure(UploadedFile $file): string
    {
        // Validasi “real image”, bukan cuma mime/extension
        $info = @getimagesize($file->getRealPath());
        if ($info === false) {
            abort(422, 'File foto KK tidak valid (bukan gambar asli).');
        }

        [$w, $h] = $info;
        if ($w > 7000 || $h > 7000) {
            abort(422, 'Resolusi foto terlalu besar. Tolong kompres foto terlebih dahulu.');
        }

        // Re-encode ke JPEG untuk buang EXIF/metadata (privacy)
        $img = @imagecreatefromstring(file_get_contents($file->getRealPath()));
        if (!$img) {
            abort(422, 'Gagal memproses gambar KK.');
        }

        $filename = 'kk/' . (string) Str::uuid() . '.jpg';
        $tmpDir = storage_path('app/tmp-kk');
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0700, true);
        }
        $tmpPath = $tmpDir . '/' . basename($filename);

        imagejpeg($img, $tmpPath, 90);
        imagedestroy($img);

        $stream = fopen($tmpPath, 'rb');
        Storage::disk('secure')->put($filename, $stream);
        if (is_resource($stream))
            fclose($stream);
        @unlink($tmpPath);

        return $filename; // contoh: kk/<uuid>.jpg
    }
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index(Request $request)
    {
        $points = collect([]);
        $umkmPoints = collect([]);

        if (Schema::hasTable('houses')) {
            $query = House::with('residents')->latest();
            if ($request->filled('q')) {
                $q = $request->string('q')->trim()->toString();
                $query->where('alamat', 'like', "%{$q}%");
            }
            $collection = $query->get();
            if ($request->filled('center_lat') && $request->filled('center_lng') && $request->filled('radius_km')) {
                $centerLat = (float) $request->input('center_lat');
                $centerLng = (float) $request->input('center_lng');
                $radiusKm = (float) $request->input('radius_km');
                $collection = $collection->filter(function ($h) use ($centerLat, $centerLng, $radiusKm) {
                    $dLat = deg2rad((float) $h->latitude - $centerLat);
                    $dLng = deg2rad((float) $h->longitude - $centerLng);
                    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($centerLat)) * cos(deg2rad((float) $h->latitude)) * sin($dLng / 2) * sin($dLng / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                    $distanceKm = 6371 * $c;
                    return $distanceKm <= $radiusKm;
                });
            }
            $sort = $request->input('sort', 'id');
            $direction = strtolower($request->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
            if (in_array($sort, ['id', 'alamat', 'created_at'])) {
                $collection = $direction === 'asc'
                    ? $collection->sortBy($sort)->values()
                    : $collection->sortByDesc($sort)->values();
            }
            $perPage = (int) $request->input('per_page', 10);
            if ($perPage <= 0 || $perPage > 100)
                $perPage = 10;
            $page = (int) ($request->input('page', 1));
            $items = $collection->forPage($page, $perPage)->values();
            $houses = new LengthAwarePaginator($items, $collection->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
            $points = $items->map(function ($h) {
                $kepalaKeluarga = $h->kepalaKeluarga();
                $jumlahAnggota = $h->jumlahPenghuni;
                $statusEkonomi = $h->residents()->where('status_ekonomi', 'miskin')->count() > 0 ? 'Miskin' : 'Tidak Miskin';
                $bantuan = [];
                if ($h->residents()->where('penerima_pkh', true)->count() > 0)
                    $bantuan[] = 'PKH';
                if ($h->residents()->where('penerima_bpnt', true)->count() > 0)
                    $bantuan[] = 'BPNT';
                if ($h->residents()->where('penerima_blt', true)->count() > 0)
                    $bantuan[] = 'BLT';

                return [
                    'id' => $h->id,
                    'alamat' => $h->alamat,
                    'lat' => (float) $h->latitude,
                    'lng' => (float) $h->longitude,
                    'kepala_kk' => $kepalaKeluarga ? $kepalaKeluarga->nama : 'Belum ada data',
                    'jumlah_anggota' => $jumlahAnggota,
                    'status_ekonomi' => $statusEkonomi,
                    'bantuan' => implode(', ', $bantuan) ?: 'Tidak ada',
                    'type' => 'house'
                ];
            });
        } else {
            $houses = collect([]);
        }

        // Get UMKM data for map
        if (Schema::hasTable('umkms')) {
            $umkmQuery = Umkm::query()->where('status', 'aktif')->latest();
            $umkmCollection = $umkmQuery->get();

            if ($request->filled('center_lat') && $request->filled('center_lng') && $request->filled('radius_km')) {
                $centerLat = (float) $request->input('center_lat');
                $centerLng = (float) $request->input('center_lng');
                $radiusKm = (float) $request->input('radius_km');
                $umkmCollection = $umkmCollection->filter(function ($u) use ($centerLat, $centerLng, $radiusKm) {
                    $dLat = deg2rad((float) $u->latitude - $centerLat);
                    $dLng = deg2rad((float) $u->longitude - $centerLng);
                    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($centerLat)) * cos(deg2rad((float) $u->latitude)) * sin($dLng / 2) * sin($dLng / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                    $distanceKm = 6371 * $c;
                    return $distanceKm <= $radiusKm;
                });
            }

            $umkmPoints = $umkmCollection->map(function ($u) {
                return [
                    'id' => $u->id,
                    'nama_usaha' => $u->nama_usaha,
                    'pemilik' => $u->pemilik,
                    'kategori' => $u->kategori_label,
                    'alamat' => $u->alamat,
                    'lat' => (float) $u->latitude,
                    'lng' => (float) $u->longitude,
                    'kontak' => $u->kontak ?: 'Tidak ada',
                    'jam_operasional' => $u->jam_operasional ?: 'Tidak diketahui',
                    'status' => $u->status_label,
                    'type' => 'umkm'
                ];
            });
        }

        return view('houses.index', ['houses' => $houses, 'points' => $points, 'umkmPoints' => $umkmPoints]);
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $canManageKk = auth()->user()->hasAnyRole(['super_admin', 'admin_desa']);

        if (($request->filled('no_kk') || $request->hasFile('foto_kk')) && !$canManageKk) {
            abort(403, 'Anda tidak punya izin mengelola data KK.');
        }

        $data = $request->validate([
            'alamat' => 'required|string|max:255',
            'no_kk' => 'nullable|string|max:16',
            'foto_kk' => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'nullable|in:Aktif,Tidak Aktif,Pindah',
            'bantuan' => 'nullable|string',
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'Aktif';
        }

        if ($request->hasFile('foto_kk')) {
            $file = $request->file('foto_kk');
            // Additional MIME type validation
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return redirect()->back()->with('error', 'File harus berupa gambar JPEG atau PNG!');
            }
            $data['foto_kk'] = $this->storeKkImageSecure($request->file('foto_kk'));
        }

        House::create([
            'alamat' => $data['alamat'],
            'no_kk' => $data['no_kk'] ?? null,
            'foto_kk' => $data['foto_kk'] ?? null,
            'latitude' => (float) $data['latitude'],
            'longitude' => (float) $data['longitude'],
            'status' => $data['status'],
            'bantuan' => $data['bantuan'] ?? null,
        ]);

        return redirect()->route('houses.index')->with('status', 'Rumah berhasil ditambahkan!');
    }

    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'alamat' => 'required|string|max:255',
            'no_kk' => 'nullable|string|max:16',
            'foto_kk' => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'nullable|in:Aktif,Tidak Aktif,Pindah',
            'bantuan' => 'nullable|string',
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'Aktif';
        }

        if ($request->hasFile('foto_kk')) {
            $file = $request->file('foto_kk');
            // Additional MIME type validation
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return redirect()->back()->with('error', 'File harus berupa gambar JPEG atau PNG!');
            }
            if ($house->foto_kk && Storage::disk('secure')->exists($house->foto_kk)) {
                Storage::disk('secure')->delete($house->foto_kk);
            }
            $data['foto_kk'] = $this->storeKkImageSecure($file);
        }

        $house->update([
            'alamat' => $data['alamat'],
            'no_kk' => $data['no_kk'] ?? null,
            'foto_kk' => $data['foto_kk'] ?? $house->foto_kk,
            'latitude' => (float) $data['latitude'],
            'longitude' => (float) $data['longitude'],
            'status' => $data['status'],
            'bantuan' => $data['bantuan'] ?? null,
        ]);

        return redirect()->route('houses.index')->with('status', 'Rumah berhasil diperbarui!');
    }

    public function destroy(House $house)
    {
        if ($house->foto_kk && Storage::disk('secure')->exists($house->foto_kk)) {
            Storage::disk('secure')->delete($house->foto_kk);
        }
        $house->delete();

        return redirect()->route('houses.index')->with('status', 'Rumah berhasil dihapus!');
    }

    public function show(House $house)
    {
        return view('houses.show', compact('house'));
    }

    public function export()
    {
        $filename = 'houses.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'alamat', 'no_kk', 'latitude', 'longitude', 'created_at']);
            House::orderBy('id')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, [
                        $row->id,
                        $row->alamat,
                        $row->no_kk,
                        $row->latitude,
                        $row->longitude,
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
            if ($header && count($header) >= 3) {
                $lower = array_map('strtolower', $header);
                $isHeader = in_array('alamat', $lower) && in_array('latitude', $lower) && in_array('longitude', $lower);
            } else {
                rewind($handle);
            }
            if (!$isHeader) {
                rewind($handle);
            }
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if ($isHeader) {
                    $map = array_flip(array_map('strtolower', $header));
                    $alamat = $row[$map['alamat']] ?? null;
                    $noKk = $row[$map['no_kk']] ?? null;
                    $lat = $row[$map['latitude']] ?? null;
                    $lng = $row[$map['longitude']] ?? null;
                } else {
                    $alamat = $row[0] ?? null;
                    $noKk = $row[1] ?? null;
                    $lat = $row[2] ?? null;
                    $lng = $row[3] ?? null;
                }
                if ($alamat === null || $lat === null || $lng === null) {
                    continue;
                }
                $latStr = str_replace(',', '.', trim((string) $lat));
                $lngStr = str_replace(',', '.', trim((string) $lng));
                $latF = (float) $latStr;
                $lngF = (float) $lngStr;
                // Validate coordinates
                if (!is_finite($latF) || !is_finite($lngF) || abs($latF) > 90 || abs($lngF) > 180) {
                    continue;
                }
                House::create([
                    'alamat' => $alamat,
                    'no_kk' => $noKk,
                    'latitude' => $latF,
                    'longitude' => $lngF,
                ]);
                $inserted++;
            }
            fclose($handle);
        }
        return redirect()->route('houses.index')->with('status', "Import berhasil: {$inserted} baris ditambahkan");
    }
}
