@extends('layouts.app')

@section('title', 'Manajemen Utang Warga')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Utang Warga</h1>
        <div class="flex space-x-2">
            <a href="{{ route('debts.report') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                📊 Laporan
            </a>
            <a href="{{ route('debts.export') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                📥 Export CSV
            </a>
            <a href="{{ route('debts.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg">
                ➕ Tambah Utang
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Utang</h3>
            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalUtang, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Dibayar</h3>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Sisa Utang</h3>
            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($sisaUtang, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama/NIK..." class="border rounded-lg px-3 py-2">
            
            <select name="status" class="border rounded-lg px-3 py-2">
                <option value="">Semua Status</option>
                <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="menunggak" {{ request('status') == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
            </select>
            
            <select name="jenis_subsidi" class="border rounded-lg px-3 py-2">
                <option value="">Semua Jenis</option>
                <option value="pupuk" {{ request('jenis_subsidi') == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                <option value="bibit" {{ request('jenis_subsidi') == 'bibit' ? 'selected' : '' }}>Bibit</option>
                <option value="alat_pertanian" {{ request('jenis_subsidi') == 'alat_pertanian' ? 'selected' : '' }}>Alat Pertanian</option>
                <option value="lainnya" {{ request('jenis_subsidi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                🔍 Filter
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Warga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Subsidi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Utang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($debts as $debt)
                <tr>
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-medium text-gray-900">{{ $debt->resident->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $debt->resident->nik }}</div>
                            <div class="text-sm text-gray-500">{{ $debt->resident->house->alamat ?? '-' }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $debt->jenis_subsidi_label }}
                        </span>
                        <div class="text-sm text-gray-500 mt-1">{{ $debt->deskripsi }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Rp {{ number_format($debt->jumlah_utang, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Rp {{ number_format($debt->jumlah_dibayar, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        Rp {{ number_format($debt->sisa_utang, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($debt->status == 'lunas') bg-green-100 text-green-800
                            @elseif($debt->status == 'menunggak') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $debt->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium space-x-2">
                        <a href="{{ route('debts.show', $debt) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                        <a href="{{ route('debts.edit', $debt) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        @if($debt->status != 'lunas')
                        <span class="text-green-600 hover:text-green-900 cursor-pointer" 
                              onclick="window.location='{{ route('debts.show', $debt) }}#pembayaran'">Bayar</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data utang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $debts->links() }}
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