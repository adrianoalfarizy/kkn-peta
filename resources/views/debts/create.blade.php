@extends('layouts.app')

@section('title', 'Tambah Utang Warga')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Utang Warga</h1>
            <a href="{{ route('debts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('debts.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Warga *</label>
                    <select name="resident_id" required class="w-full border rounded-lg px-3 py-2 @error('resident_id') border-red-500 @enderror">
                        <option value="">Pilih Warga</option>
                        @foreach($residents as $resident)
                        <option value="{{ $resident->id }}" {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                            {{ $resident->nama }} - {{ $resident->nik }} ({{ $resident->house->alamat ?? '-' }})
                        </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jenis Subsidi *</label>
                    <select name="jenis_subsidi" required class="w-full border rounded-lg px-3 py-2 @error('jenis_subsidi') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="pupuk" {{ old('jenis_subsidi') == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                        <option value="bibit" {{ old('jenis_subsidi') == 'bibit' ? 'selected' : '' }}>Bibit</option>
                        <option value="alat_pertanian" {{ old('jenis_subsidi') == 'alat_pertanian' ? 'selected' : '' }}>Alat Pertanian</option>
                        <option value="lainnya" {{ old('jenis_subsidi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_subsidi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi *</label>
                    <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" required
                           placeholder="Contoh: Pupuk NPK 50kg" 
                           class="w-full border rounded-lg px-3 py-2 @error('deskripsi') border-red-500 @enderror">
                    @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah Utang (Rp) *</label>
                    <input type="number" name="jumlah_utang" value="{{ old('jumlah_utang') }}" required min="0" step="0.01"
                           placeholder="0" 
                           class="w-full border rounded-lg px-3 py-2 @error('jumlah_utang') border-red-500 @enderror">
                    @error('jumlah_utang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Utang *</label>
                    <input type="date" name="tanggal_utang" value="{{ old('tanggal_utang', date('Y-m-d')) }}" required
                           class="w-full border rounded-lg px-3 py-2 @error('tanggal_utang') border-red-500 @enderror">
                    @error('tanggal_utang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jatuh Tempo (Opsional)</label>
                    <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}"
                           class="w-full border rounded-lg px-3 py-2 @error('jatuh_tempo') border-red-500 @enderror">
                    @error('jatuh_tempo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3" 
                              class="w-full border rounded-lg px-3 py-2 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('debts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection