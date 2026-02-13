<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class DebtController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            // Auto-update status menunggak with transaction
            DB::transaction(function () {
                Debt::where('status', 'belum_lunas')
                    ->whereNotNull('jatuh_tempo')
                    ->where('jatuh_tempo', '<', now())
                    ->update(['status' => 'menunggak']);
            });
            
            $query = Debt::with('resident.house')->latest();

            if ($request->filled('search')) {
                $search = $request->string('search')->trim()->toString();
                $query->whereHas('resident', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('jenis_subsidi')) {
                $query->where('jenis_subsidi', $request->jenis_subsidi);
            }

            $debts = $query->paginate(15);
            
            // Summary statistics
            $totalUtang = Debt::sum('jumlah_utang');
            $totalDibayar = Debt::sum('jumlah_dibayar');
            $sisaUtang = $totalUtang - $totalDibayar;
            
            return view('debts.index', compact('debts', 'totalUtang', 'totalDibayar', 'sisaUtang'));
        } catch (\Exception $e) {
            Log::error('Failed to load debts', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memuat data utang.');
        }
    }

    public function create()
    {
        $residents = Resident::with('house')->orderBy('nama')->get();
        return view('debts.create', compact('residents'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'resident_id' => 'required|exists:residents,id',
                'jenis_subsidi' => 'required|in:pupuk,bibit,alat_pertanian,lainnya',
                'deskripsi' => 'required|string|max:255',
                'jumlah_utang' => 'required|numeric|min:0',
                'tanggal_utang' => 'required|date',
                'jatuh_tempo' => 'nullable|date|after:tanggal_utang',
                'catatan' => 'nullable|string',
            ]);

            $debt = Debt::create($request->all());

            Log::info('Debt created', ['debt_id' => $debt->id, 'by' => auth()->id()]);
            return redirect()->route('debts.index')->with('status', 'Data utang berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Failed to create debt', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menambahkan data utang.');
        }
    }

    public function show(Debt $debt)
    {
        $debt->load('resident.house');
        return view('debts.show', compact('debt'));
    }

    public function edit(Debt $debt)
    {
        $residents = Resident::with('house')->orderBy('nama')->get();
        return view('debts.edit', compact('debt', 'residents'));
    }

    public function update(Request $request, Debt $debt)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'jenis_subsidi' => 'required|in:pupuk,bibit,alat_pertanian,lainnya',
            'deskripsi' => 'required|string|max:255',
            'jumlah_utang' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0|lte:jumlah_utang',
            'status' => 'required|in:belum_lunas,lunas,menunggak',
            'tanggal_utang' => 'required|date',
            'jatuh_tempo' => 'nullable|date|after:tanggal_utang',
            'catatan' => 'nullable|string',
        ]);

        $debt->update($request->all());

        return redirect()->route('debts.index')->with('status', 'Data utang berhasil diperbarui!');
    }

    public function destroy(Debt $debt)
    {
        if ($debt->jumlah_dibayar > 0) {
            return redirect()->route('debts.index')->with('error', 'Tidak dapat menghapus utang yang sudah ada pembayaran!');
        }
        
        $debt->delete();
        return redirect()->route('debts.index')->with('status', 'Data utang berhasil dihapus!');
    }

    public function payment(Request $request, Debt $debt)
    {
        try {
            $request->validate([
                'jumlah_bayar' => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:' . $debt->sisa_utang
                ],
            ], [
                'jumlah_bayar.max' => 'Jumlah pembayaran tidak boleh melebihi sisa utang (Rp ' . number_format($debt->sisa_utang, 0, ',', '.') . ')',
                'jumlah_bayar.min' => 'Jumlah pembayaran minimal Rp 1',
            ]);

            DB::transaction(function () use ($debt, $request) {
                $jumlahDibayar = $debt->jumlah_dibayar + $request->jumlah_bayar;
                $status = $jumlahDibayar >= $debt->jumlah_utang ? 'lunas' : 'belum_lunas';

                $debt->update([
                    'jumlah_dibayar' => $jumlahDibayar,
                    'status' => $status,
                ]);
            });

            Log::info('Debt payment recorded', ['debt_id' => $debt->id, 'amount' => $request->jumlah_bayar, 'by' => auth()->id()]);
            return redirect()->route('debts.show', $debt)->with('status', 'Pembayaran berhasil dicatat!');
        } catch (\Exception $e) {
            Log::error('Failed to record payment', ['debt_id' => $debt->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mencatat pembayaran.');
        }
    }

    public function report()
    {
        $residents = Resident::with(['debts', 'house'])
            ->whereHas('debts')
            ->get()
            ->map(function ($resident) {
                return [
                    'resident' => $resident,
                    'total_utang' => $resident->debts->sum('jumlah_utang'),
                    'total_dibayar' => $resident->debts->sum('jumlah_dibayar'),
                    'sisa_utang' => $resident->debts->sum('jumlah_utang') - $resident->debts->sum('jumlah_dibayar'),
                    'jumlah_transaksi' => $resident->debts->count(),
                ];
            })
            ->sortByDesc('sisa_utang');

        return view('debts.report', compact('residents'));
    }

    public function export()
    {
        $filename = 'laporan_utang_warga.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'NIK', 'Nama', 'Alamat', 'Jenis Subsidi', 'Deskripsi', 
                'Jumlah Utang', 'Jumlah Dibayar', 'Sisa Utang', 'Status', 
                'Tanggal Utang', 'Jatuh Tempo'
            ]);

            Debt::with('resident.house')->chunk(200, function ($debts) use ($out) {
                foreach ($debts as $debt) {
                    fputcsv($out, [
                        $debt->resident->nik,
                        $debt->resident->nama,
                        $debt->resident->house->alamat ?? '-',
                        $debt->jenis_subsidi_label,
                        $debt->deskripsi,
                        $debt->jumlah_utang,
                        $debt->jumlah_dibayar,
                        $debt->sisa_utang,
                        $debt->status_label,
                        $debt->tanggal_utang->format('Y-m-d'),
                        $debt->jatuh_tempo?->format('Y-m-d') ?? '-',
                    ]);
                }
            });

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}