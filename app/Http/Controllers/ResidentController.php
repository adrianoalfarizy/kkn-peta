<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ResidentController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Resident::with('house')->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_ekonomi')) {
            $query->where('status_ekonomi', $request->status_ekonomi);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $residents = $query->paginate(15);
        
        return view('residents.index', compact('residents'));
    }

    public function create()
    {
        $houses = House::orderBy('alamat')->get();
        return view('residents.create', compact('houses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'nik' => 'required|string|size:16|unique:residents',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'status_keluarga' => 'required|in:kepala,istri,anak,orang_tua,lainnya',
            'status_kawin' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_ekonomi' => 'required|in:miskin,tidak_miskin,rentan_miskin',
            'penerima_pkh' => 'boolean',
            'penerima_bpnt' => 'boolean',
            'penerima_blt' => 'boolean',
            'no_hp' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        Resident::create($data);

        return redirect()->route('residents.index')->with('status', 'Data warga berhasil ditambahkan!');
    }

    public function show(Resident $resident)
    {
        $resident->load('house', 'socialAids');
        return view('residents.show', compact('resident'));
    }

    public function edit(Resident $resident)
    {
        $houses = House::orderBy('alamat')->get();
        return view('residents.edit', compact('resident', 'houses'));
    }

    public function update(Request $request, Resident $resident)
    {
        $data = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'nik' => 'required|string|size:16|unique:residents,nik,' . $resident->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'status_keluarga' => 'required|in:kepala,istri,anak,orang_tua,lainnya',
            'status_kawin' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_ekonomi' => 'required|in:miskin,tidak_miskin,rentan_miskin',
            'penerima_pkh' => 'boolean',
            'penerima_bpnt' => 'boolean',
            'penerima_blt' => 'boolean',
            'no_hp' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        $resident->update($data);

        return redirect()->route('residents.index')->with('status', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();
        return redirect()->route('residents.index')->with('status', 'Data warga berhasil dihapus!');
    }

    public function export()
    {
        $filename = 'data_warga_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'NIK', 'Nama', 'Jenis Kelamin', 'Tanggal Lahir', 'Umur', 'Status Keluarga',
                'Status Kawin', 'Agama', 'Pendidikan', 'Pekerjaan', 'Status Ekonomi',
                'PKH', 'BPNT', 'BLT', 'No HP', 'Alamat'
            ]);

            Resident::with('house')->chunk(200, function ($residents) use ($out) {
                foreach ($residents as $resident) {
                    fputcsv($out, [
                        $resident->nik,
                        $resident->nama,
                        $resident->jenis_kelamin,
                        $resident->tanggal_lahir->format('d/m/Y'),
                        $resident->umur,
                        $resident->status_keluarga,
                        $resident->status_kawin,
                        $resident->agama,
                        $resident->pendidikan,
                        $resident->pekerjaan,
                        $resident->status_ekonomi,
                        $resident->penerima_pkh ? 'Ya' : 'Tidak',
                        $resident->penerima_bpnt ? 'Ya' : 'Tidak',
                        $resident->penerima_blt ? 'Ya' : 'Tidak',
                        $resident->no_hp,
                        $resident->house->alamat,
                    ]);
                }
            });

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}