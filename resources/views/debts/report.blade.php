@extends('layouts.app')

@section('title', 'Laporan Utang per Warga')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📊 Laporan Utang per Warga</h1>
        <div class="flex space-x-2">
            <a href="{{ route('debts.export') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                📥 Export CSV
            </a>
            <a href="{{ route('debts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Warga Berutang</h3>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $residents->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Utang</h3>
            <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($residents->sum('total_utang'), 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Dibayar</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($residents->sum('total_dibayar'), 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase">Sisa Utang</h3>
            <p class="text-2xl font-bold text-orange-600 mt-2">Rp {{ number_format($residents->sum('sisa_utang'), 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Warga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Utang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Dibayar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Sisa Utang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($residents as $index => $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="font-medium text-gray-900">{{ $data['resident']->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $data['resident']->nik }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $data['resident']->house->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 text-right">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $data['jumlah_transaksi'] }} transaksi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 text-right font-medium">
                            Rp {{ number_format($data['total_utang'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-green-600 text-right font-medium">
                            Rp {{ number_format($data['total_dibayar'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right font-bold">
                            <span class="{{ $data['sisa_utang'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                Rp {{ number_format($data['sisa_utang'], 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $progress = $data['total_utang'] > 0 ? ($data['total_dibayar'] / $data['total_utang']) * 100 : 0;
                            @endphp
                            <div class="flex items-center justify-center">
                                <div class="w-24">
                                    <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full {{ $progress >= 100 ? 'bg-green-500' : ($progress >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                             style="width: {{ min($progress, 100) }}%"></div>
                                    </div>
                                    <p class="text-xs text-center mt-1 text-gray-600">{{ number_format($progress, 0) }}%</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data utang warga.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($residents->count() > 0)
                <tfoot class="bg-gray-100 font-bold">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right text-gray-900">TOTAL:</td>
                        <td class="px-6 py-4 text-right text-red-600">
                            Rp {{ number_format($residents->sum('total_utang'), 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-green-600">
                            Rp {{ number_format($residents->sum('total_dibayar'), 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-orange-600">
                            Rp {{ number_format($residents->sum('sisa_utang'), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Catatan:</strong> Laporan ini menampilkan total utang per warga dari semua transaksi subsidi pertanian (pupuk, bibit, alat pertanian).
                    Data diurutkan berdasarkan sisa utang terbesar.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection