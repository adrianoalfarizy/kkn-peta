<?php

namespace App\Http\Controllers;

use App\Models\SocialAid;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SocialAidController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = SocialAid::latest();
        
        if ($request->filled('jenis_bantuan')) {
            $query->where('jenis_bantuan', $request->jenis_bantuan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $socialAids = $query->paginate(10);
        
        return view('social-aids.index', compact('socialAids'));
    }

    public function create()
    {
        return view('social-aids.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:pkh,bpnt,blt,sembako,tunai,lainnya',
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_distribusi' => 'required|date',
            'target_penerima' => 'required|integer|min:1',
            'sumber_dana' => 'nullable|string|max:255',
        ]);

        $data['status'] = 'planned';
        $data['realisasi_penerima'] = 0;

        SocialAid::create($data);

        return redirect()->route('social-aids.index')->with('status', 'Program bantuan berhasil ditambahkan!');
    }

    public function show(SocialAid $socialAid)
    {
        $socialAid->load('recipients.house');
        return view('social-aids.show', compact('socialAid'));
    }

    public function edit(SocialAid $socialAid)
    {
        return view('social-aids.edit', compact('socialAid'));
    }

    public function update(Request $request, SocialAid $socialAid)
    {
        $data = $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|in:pkh,bpnt,blt,sembako,tunai,lainnya',
            'deskripsi' => 'nullable|string',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_distribusi' => 'required|date',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
            'target_penerima' => 'required|integer|min:1',
            'sumber_dana' => 'nullable|string|max:255',
        ]);

        $socialAid->update($data);

        return redirect()->route('social-aids.index')->with('status', 'Program bantuan berhasil diperbarui!');
    }

    public function destroy(SocialAid $socialAid)
    {
        $socialAid->delete();
        return redirect()->route('social-aids.index')->with('status', 'Program bantuan berhasil dihapus!');
    }

    public function recipients(SocialAid $socialAid)
    {
        $eligibleResidents = Resident::with('house')
            ->where('status_ekonomi', 'miskin')
            ->whereNotIn('id', $socialAid->recipients->pluck('id'))
            ->get();

        return view('social-aids.recipients', compact('socialAid', 'eligibleResidents'));
    }

    public function addRecipient(Request $request, SocialAid $socialAid)
    {
        $request->validate([
            'resident_ids' => 'required|array',
            'resident_ids.*' => 'exists:residents,id',
        ]);

        foreach ($request->resident_ids as $residentId) {
            $socialAid->recipients()->attach($residentId, [
                'status_penerimaan' => 'eligible',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('social-aids.show', $socialAid)
            ->with('status', 'Penerima bantuan berhasil ditambahkan!');
    }

    public function updateRecipientStatus(Request $request, SocialAid $socialAid, Resident $resident)
    {
        $data = $request->validate([
            'status_penerimaan' => 'required|in:eligible,received,rejected,pending',
            'tanggal_terima' => 'nullable|date',
            'jumlah_diterima' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $socialAid->recipients()->updateExistingPivot($resident->id, $data);

        if ($data['status_penerimaan'] === 'received') {
            $socialAid->increment('realisasi_penerima');
        }

        return redirect()->route('social-aids.show', $socialAid)
            ->with('status', 'Status penerima berhasil diperbarui!');
    }
}