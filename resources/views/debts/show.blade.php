@extends('layouts.app')

@section('title', 'Detail Utang Warga')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail Utang Warga</h1>
            <a href="{{ route('debts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                ← Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Info Utang -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Warga -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Warga</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium">{{ $debt->resident->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-medium">{{ $debt->resident->nik }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium">{{ $debt->resident->house->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Utang -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Utang</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jenis Subsidi:</span>
                            <span class="font-medium">{{ $debt->jenis_subsidi_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Deskripsi:</span>
                            <span class="font-medium">{{ $debt->deskripsi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Utang:</span>
                            <span class="font-medium">{{ $debt->tanggal_utang->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jatuh Tempo:</span>
                            <span class="font-medium">{{ $debt->jatuh_tempo?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                        @if($debt->catatan)
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-500 mb-1">Catatan:</p>
                            <p class="text-gray-700">{{ $debt->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Form Pembayaran -->
                @if($debt->status != 'lunas')
                <div id="pembayaran" class="bg-blue-50 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">💰 Catat Pembayaran</h2>
                    <form method="POST" action="{{ route('debts.payment', $debt) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Jumlah Bayar (Rp)</label>
                            <input type="number" name="jumlah_bayar" min="0" max="{{ $debt->sisa_utang }}" step="0.01" required
                                   placeholder="Masukkan jumlah pembayaran"
                                   class="w-full border rounded-lg px-3 py-2 @error('jumlah_bayar') border-red-500 @enderror">
                            <p class="text-sm text-gray-500 mt-1">Maksimal: Rp {{ number_format($debt->sisa_utang, 0, ',', '.') }}</p>
                            @error('jumlah_bayar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium">
                            Simpan Pembayaran
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Summary & Actions -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>
                    <div class="text-center">
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full 
                            @if($debt->status == 'lunas') bg-green-100 text-green-800
                            @elseif($debt->status == 'menunggak') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $debt->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">Ringkasan Utang</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-indigo-100 text-sm">Total Utang</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($debt->jumlah_utang, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-t border-indigo-400 pt-3">
                            <p class="text-indigo-100 text-sm">Sudah Dibayar</p>
                            <p class="text-xl font-bold">Rp {{ number_format($debt->jumlah_dibayar, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-t border-indigo-400 pt-3">
                            <p class="text-indigo-100 text-sm">Sisa Utang</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($debt->sisa_utang, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-t border-indigo-400 pt-3">
                            <p class="text-indigo-100 text-sm">Progress Pelunasan</p>
                            <div class="mt-2">
                                <div class="bg-indigo-300 rounded-full h-3 overflow-hidden">
                                    <div class="bg-white h-full rounded-full" style="width: {{ $debt->persentase_lunas }}%"></div>
                                </div>
                                <p class="text-right text-sm mt-1">{{ number_format($debt->persentase_lunas, 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-2">
                        <a href="{{ route('debts.edit', $debt) }}" 
                           class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center px-4 py-2 rounded-lg">
                            ✏️ Edit Data
                        </a>
                        <form method="POST" action="{{ route('debts.destroy', $debt) }}" 
                              onsubmit="return confirm('⚠️ Yakin ingin menghapus data utang ini?\n\nData yang dihapus tidak dapat dikembalikan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"
                                    {{ $debt->jumlah_dibayar > 0 ? 'disabled title="Tidak dapat menghapus utang yang sudah ada pembayaran"' : '' }}>
                                🗑️ Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('status') }}', 'success');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('error') }}', 'error');
    });
</script>
@endif
@endsection