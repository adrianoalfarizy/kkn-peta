<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Resident;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalWarga = Resident::count();
        $totalKK = House::count();
        $wargaMiskin = Resident::where('status_ekonomi', 'miskin')->count();
        $penerimaBantuan = Resident::where(function($q) {
            $q->where('penerima_pkh', true)
              ->orWhere('penerima_bpnt', true)
              ->orWhere('penerima_blt', true);
        })->count();
        $penerimaPKH = Resident::where('penerima_pkh', true)->count();
        $penerimaBPNT = Resident::where('penerima_bpnt', true)->count();
        $penerimaBLT = Resident::where('penerima_blt', true)->count();
        $lakiLaki = Resident::where('jenis_kelamin', 'L')->count();
        $perempuan = Resident::where('jenis_kelamin', 'P')->count();
        $kepalaKeluarga = Resident::where('status_keluarga', 'kepala')->count();
        
        // Debt statistics
        $totalUtang = Debt::sum('jumlah_utang');
        $totalDibayar = Debt::sum('jumlah_dibayar');
        $sisaUtang = $totalUtang - $totalDibayar;
        $wargaBerutang = Debt::distinct('resident_id')->count('resident_id');

        return view('dashboard', compact(
            'totalWarga', 'totalKK', 'wargaMiskin', 'penerimaBantuan',
            'penerimaPKH', 'penerimaBPNT', 'penerimaBLT',
            'lakiLaki', 'perempuan', 'kepalaKeluarga',
            'totalUtang', 'totalDibayar', 'sisaUtang', 'wargaBerutang'
        ));
    }
}