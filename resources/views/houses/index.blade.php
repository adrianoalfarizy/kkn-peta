@php($title = 'Sistem Peta Desa Gunungsari')
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-800 to-green-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Sistem Informasi Peta Desa Gunungsari
            </h1>
            <p class="text-xl md:text-2xl text-green-100 mb-2">
                Data Rumah Warga & UMKM
            </p>
            <p class="text-green-200 mb-6">
                Kecamatan Dawarblandong, Kabupaten Mojokerto
            </p>
            
            <!-- Logo Akademik -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 mb-8 pb-6">
                <div class="text-green-100 text-sm font-medium">Program Kuliah Kerja Nyata</div>
                <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                    <img src="{{ asset('images/logo-umg.png') }}" alt="Logo Kampus" class="logo-hero-campus w-auto object-contain opacity-85">
                    <img src="{{ asset('images/logo-kelompok.png') }}" alt="Logo Kelompok KKN" class="logo-hero-kkn w-auto object-contain opacity-85">
                </div>
            </div>
            
            <p class="text-lg text-green-100 max-w-3xl mx-auto mb-8">
                Mendukung pendataan rumah warga dan UMKM, perencanaan program, serta distribusi bantuan berbasis lokasi untuk meningkatkan pelayanan kepada masyarakat
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#peta" class="inline-flex items-center justify-center px-8 py-3 bg-white text-green-800 font-semibold rounded-lg hover:bg-green-50 transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Lihat Peta
                </a>
                @auth
                    <a href="{{ route('houses.create') }}" class="inline-flex items-center justify-center px-8 py-3 bg-green-900 text-white font-semibold rounded-lg hover:bg-green-950 transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        Tambah Data Rumah
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white border-b" style="position: relative; z-index: 10;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-bold" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ $houses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $houses->total() : count($houses) }}</div>
                        <div class="text-sm font-semibold" style="color: #ffffff !important; font-size: 0.875rem !important;">Total Rumah</div>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-bold" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ count($umkmPoints ?? []) }}</div>
                        <div class="text-sm font-semibold" style="color: #ffffff !important; font-size: 0.875rem !important;">Total UMKM</div>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-bold" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ count($points) + count($umkmPoints ?? []) }}</div>
                        <div class="text-sm font-semibold" style="color: #ffffff !important; font-size: 0.875rem !important;">Titik Peta</div>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-bold" style="color: #ffffff !important; font-size: 2.5rem !important;">100%</div>
                        <div class="text-sm font-semibold" style="color: #ffffff !important; font-size: 0.875rem !important;">Akurasi Data</div>
                    </div>
                    <svg class="w-12 h-12 text-orange-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-bold" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ date('Y') }}</div>
                        <div class="text-sm font-semibold" style="color: #ffffff !important; font-size: 0.875rem !important;">Tahun Aktif</div>
                    </div>
                    <svg class="w-12 h-12 text-indigo-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section id="peta" class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Peta Sebaran Rumah Warga & UMKM</h2>
            <p class="text-gray-600">Visualisasi lokasi rumah warga dan UMKM Desa Gunungsari</p>
        </div>

        <!-- Filter Radius -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4 text-gray-900">Filter & Tampilan Peta</h3>
            
            <!-- Map Display Toggle -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Tampilkan di Peta</label>
                <div class="flex flex-wrap gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="showHouses" checked class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Rumah Warga ({{ count($points) }})</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="showUmkms" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">UMKM ({{ count($umkmPoints ?? []) }})</span>
                    </label>
                </div>
            </div>
            
            <form method="GET" action="{{ route('houses.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Latitude Pusat</label>
                    <input id="center_lat" type="text" name="center_lat" value="{{ request('center_lat') }}" placeholder="-7.123456" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Longitude Pusat</label>
                    <input id="center_lng" type="text" name="center_lng" value="{{ request('center_lng') }}" placeholder="112.654321" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Radius (km)</label>
                    <input id="radius_km" type="number" step="0.1" min="0" name="radius_km" value="{{ request('radius_km') }}" placeholder="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div class="flex items-end gap-2">
                    <button type="button" onclick="useMapCenter()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Gunakan Pusat Peta
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Map Container -->
        <div id="map" class="w-full h-[500px] rounded-lg shadow-lg border-4 border-white" style="height: 500px !important; min-height: 500px !important; z-index: 1;"></div>
    </div>
</section>

<!-- Data Section -->
<section id="data" class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Data Rumah Warga</h2>
                <p class="text-gray-600">Daftar lengkap rumah warga yang terdata</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <form method="GET" action="{{ route('houses.index') }}" class="flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari alamat..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition">
                        Cari
                    </button>
                </form>
                @auth
                    <a href="{{ route('houses.export') }}" class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        Ekspor CSV
                    </a>
                @endauth
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Alamat</th>
                            @auth
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">No KK</th>
                            @endauth
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Koordinat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal Input</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($houses as $index => $house)
                            <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($houses instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($houses->firstItem() + $index) : ($index + 1) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $house->alamat }}</td>
                                @auth
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $house->no_kk ?: '-' }}</td>
                                @endauth
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-mono bg-gray-100 px-3 py-1 rounded">{{ $house->latitude }}, {{ $house->longitude }}</span>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $house->latitude }},{{ $house->longitude }}'); showToast('Koordinat disalin!', 'success')" class="text-gray-400 hover:text-green-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/><path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/></svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Illuminate\Support\Carbon::parse($house->created_at)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('houses.show', $house) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded hover:bg-blue-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                            Lihat
                                        </a>
                                        @auth
                                            <a href="{{ route('houses.edit', $house) }}" class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded hover:bg-yellow-200 transition">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('houses.destroy', $house) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded hover:bg-red-200 transition">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endauth
                                        <button type="button" onclick="focusMarker({{ $house->latitude }}, {{ $house->longitude }})" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                            Peta
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/></svg>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada data rumah</p>
                                    <p class="text-gray-400 text-sm mt-2">Silakan tambahkan data rumah warga terlebih dahulu</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($houses, 'links'))
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $houses->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Import Section (Admin Only) -->
@auth
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Import Data dari CSV</h3>
            <p class="text-gray-600 mb-6">Upload file CSV untuk menambahkan data rumah secara massal</p>
            <form id="importForm" action="{{ route('houses.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="file" name="csv" accept=".csv,text/csv" required class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:border-green-500 focus:outline-none">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-green-700 text-white font-semibold rounded-lg hover:bg-green-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="btn-text">Import Data</span>
                        <span class="btn-loading hidden">Memproses...</span>
                    </button>
                </div>
                <p class="text-sm text-gray-500">Format: alamat, latitude, longitude (baris pertama boleh header)</p>
            </form>
        </div>
    </div>
</section>
@endauth

<!-- Panduan Section -->
<section id="panduan" class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Panduan Penggunaan</h2>
            <p class="text-gray-600">Petunjuk lengkap menggunakan sistem</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-green-50 rounded-lg p-6 border-2 border-green-200">
                <div class="w-12 h-12 bg-green-700 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">1. Login Admin</h3>
                <p class="text-gray-600 text-sm">Gunakan akun admin untuk mengelola data. Email: admin@gunungsari.id</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-6 border-2 border-blue-200">
                <div class="w-12 h-12 bg-blue-700 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">2. Tambah Data</h3>
                <p class="text-gray-600 text-sm">Klik "Tambah Data" → Isi alamat → Klik peta untuk koordinat → Simpan</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-6 border-2 border-purple-200">
                <div class="w-12 h-12 bg-purple-700 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">3. Import CSV</h3>
                <p class="text-gray-600 text-sm">Upload file CSV dengan format: alamat, latitude, longitude</p>
            </div>
        </div>
    </div>
</section>

<!-- Info Desa Section -->
<section class="bg-gradient-to-r from-green-50 to-blue-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Data Keseluruhan Desa Gunungsari</h2>
            <p class="text-gray-600">Ringkasan data dan statistik terkini</p>
        </div>
        
        <!-- Data Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ $houses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $houses->total() : count($houses) }}</div>
                <div class="text-sm font-medium text-gray-600">Total Rumah Warga</div>
                <div class="text-xs text-green-600 mt-2">✓ Terdata lengkap</div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ count($umkmPoints ?? []) }}</div>
                <div class="text-sm font-medium text-gray-600">UMKM Aktif</div>
                <div class="text-xs text-blue-600 mt-2">✓ Mendukung ekonomi lokal</div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ count($points) + count($umkmPoints ?? []) }}</div>
                <div class="text-sm font-medium text-gray-600">Total Titik Peta</div>
                <div class="text-xs text-purple-600 mt-2">✓ Koordinat GPS akurat</div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ date('Y') }}</div>
                <div class="text-sm font-medium text-gray-600">Tahun Sistem Aktif</div>
                <div class="text-xs text-orange-600 mt-2">✓ Data terkini</div>
            </div>
        </div>
        
        <!-- Detailed Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profil Desa -->
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Profil Desa
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nama Desa</span>
                        <span class="font-semibold text-gray-900">Gunungsari</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Kecamatan</span>
                        <span class="font-semibold text-gray-900">Dawarblandong</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Kabupaten</span>
                        <span class="font-semibold text-gray-900">Mojokerto</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Provinsi</span>
                        <span class="font-semibold text-gray-900">Jawa Timur</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Kode Pos</span>
                        <span class="font-semibold text-gray-900">61315</span>
                    </div>
                </div>
            </div>
            
            <!-- Kategori UMKM -->
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                    Kategori UMKM
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                            <span class="text-gray-600">Kuliner</span>
                        </div>
                        <span class="font-semibold text-gray-900">3</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                            <span class="text-gray-600">Retail/Toko</span>
                        </div>
                        <span class="font-semibold text-gray-900">2</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-gray-600">Jasa</span>
                        </div>
                        <span class="font-semibold text-gray-900">3</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                            <span class="text-gray-600">Pertanian</span>
                        </div>
                        <span class="font-semibold text-gray-900">1</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-400 rounded-full mr-3"></div>
                            <span class="text-gray-600">Kerajinan</span>
                        </div>
                        <span class="font-semibold text-gray-900">1</span>
                    </div>
                </div>
            </div>
            
            <!-- Fitur Sistem -->
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                    Fitur Sistem
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start py-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                        <div>
                            <div class="font-medium text-gray-900">Pemetaan Interaktif</div>
                            <div class="text-sm text-gray-600">Visualisasi lokasi dengan clustering</div>
                        </div>
                    </div>
                    <div class="flex items-start py-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                        <div>
                            <div class="font-medium text-gray-900">Filter & Pencarian</div>
                            <div class="text-sm text-gray-600">Berdasarkan radius dan kategori</div>
                        </div>
                    </div>
                    <div class="flex items-start py-2">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                        <div>
                            <div class="font-medium text-gray-900">Export/Import CSV</div>
                            <div class="text-sm text-gray-600">Backup dan input data massal</div>
                        </div>
                    </div>
                    <div class="flex items-start py-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                        <div>
                            <div class="font-medium text-gray-900">GPS Integration</div>
                            <div class="text-sm text-gray-600">Koordinat akurat dan reverse geocoding</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats Bar -->
        <div class="mt-12 bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Statistik Cepat</h3>
                <p class="text-sm text-gray-600">Data terupdate otomatis</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg">
                    <div class="text-2xl font-bold text-green-700">100%</div>
                    <div class="text-xs font-medium text-gray-700">Data Terverifikasi</div>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg">
                    <div class="text-2xl font-bold text-blue-700">{{ count($umkmPoints ?? []) > 0 ? '✓' : '0' }}</div>
                    <div class="text-xs font-medium text-gray-700">UMKM Aktif</div>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg">
                    <div class="text-2xl font-bold text-purple-700">GPS</div>
                    <div class="text-xs font-medium text-gray-700">Koordinat Akurat</div>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg">
                    <div class="text-2xl font-bold text-orange-700">24/7</div>
                    <div class="text-xs font-medium text-gray-700">Sistem Online</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toast Notification -->
@if(session('status'))
    <script>
        showToast('{{ session('status') }}', 'success');
    </script>
@endif

<!-- Import Form Script -->
@auth
<script>
    document.getElementById('importForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.querySelector('.btn-text').classList.add('hidden');
        btn.querySelector('.btn-loading').classList.remove('hidden');
    });
</script>
@endauth

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<!-- Map Script -->
<script>
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const points = @json($points);
            const umkmPoints = @json($umkmPoints ?? []);
            
            console.log('Points:', points.length, 'UMKM Points:', umkmPoints.length);
            
            const allPoints = [...points, ...umkmPoints];
            const defaultLat = allPoints.length ? (allPoints.reduce((s,p)=>s+p.lat,0) / allPoints.length) : -7.5;
            const defaultLng = allPoints.length ? (allPoints.reduce((s,p)=>s+p.lng,0) / allPoints.length) : 112.5;
            
            // Check if Leaflet is loaded
            if (typeof L === 'undefined') {
                console.error('Leaflet is not loaded!');
                return;
            }
            
            const map = L.map('map').setView([defaultLat, defaultLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            const houseCluster = L.markerClusterGroup();
            const umkmCluster = L.markerClusterGroup();
            
            // Custom icons
            const houseIcon = L.divIcon({
                html: '<div style="background-color: #15803d; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                className: 'custom-div-icon',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
            
            const umkmIcon = L.divIcon({
                html: '<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                className: 'custom-div-icon',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
            
            // Add house markers
            points.forEach(p => {
                @auth
                const marker = L.marker([p.lat, p.lng], {icon: houseIcon}).bindPopup(`
                    <div class="p-3 min-w-[250px]">
                        <div class="font-bold text-green-800 mb-2 text-base">${p.alamat}</div>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kepala KK:</span>
                                <span class="font-medium">${p.kepala_kk}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Anggota:</span>
                                <span class="font-medium">${p.jumlah_anggota} orang</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Ekonomi:</span>
                                <span class="font-medium ${p.status_ekonomi === 'Miskin' ? 'text-red-600' : 'text-green-600'}">${p.status_ekonomi}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bantuan:</span>
                                <span class="font-medium text-blue-600">${p.bantuan}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t text-xs text-gray-500">
                            <div>Lat: ${p.lat}</div>
                            <div>Lng: ${p.lng}</div>
                        </div>
                    </div>
                `);
                @else
                const marker = L.marker([p.lat, p.lng], {icon: houseIcon}).bindPopup(`
                    <div class="p-3 min-w-[250px]">
                        <div class="font-bold text-green-800 mb-2 text-base">${p.alamat}</div>
                        <div class="mt-2 pt-2 border-t text-xs text-gray-500">
                            <div>Lat: ${p.lat}</div>
                            <div>Lng: ${p.lng}</div>
                        </div>
                        <div class="mt-2 pt-2 border-t text-xs text-gray-600">
                            <em>Login untuk melihat detail lengkap</em>
                        </div>
                    </div>
                `);
                @endauth
                houseCluster.addLayer(marker);
            });
            
            // Add UMKM markers
            umkmPoints.forEach(u => {
                const marker = L.marker([u.lat, u.lng], {icon: umkmIcon}).bindPopup(`
                    <div class="p-3 min-w-[250px]">
                        <div class="font-bold text-blue-800 mb-2 text-base">${u.nama_usaha}</div>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pemilik:</span>
                                <span class="font-medium">${u.pemilik}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-medium text-blue-600">${u.kategori}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium ${u.status === 'Aktif' ? 'text-green-600' : 'text-red-600'}">${u.status}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kontak:</span>
                                <span class="font-medium">${u.kontak}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jam:</span>
                                <span class="font-medium">${u.jam_operasional}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t">
                            <div class="text-xs text-gray-600">${u.alamat}</div>
                        </div>
                        <div class="mt-2 pt-2 border-t text-xs text-gray-500">
                            <div>Lat: ${u.lat}</div>
                            <div>Lng: ${u.lng}</div>
                        </div>
                    </div>
                `);
                umkmCluster.addLayer(marker);
            });
            
            // Add clusters to map
            map.addLayer(houseCluster);
            map.addLayer(umkmCluster);
            
            // Toggle functionality
            document.getElementById('showHouses').addEventListener('change', function() {
                if (this.checked) {
                    map.addLayer(houseCluster);
                } else {
                    map.removeLayer(houseCluster);
                }
            });
            
            document.getElementById('showUmkms').addEventListener('change', function() {
                if (this.checked) {
                    map.addLayer(umkmCluster);
                } else {
                    map.removeLayer(umkmCluster);
                }
            });
            
            window.focusMarker = function(lat, lng) {
                map.setView([lat, lng], 17);
                document.getElementById('peta').scrollIntoView({ behavior: 'smooth' });
            };
            
            window.useMapCenter = function() {
                const center = map.getCenter();
                document.getElementById('center_lat').value = center.lat.toFixed(7);
                document.getElementById('center_lng').value = center.lng.toFixed(7);
            };
            
            const rLat = {{ request('center_lat') ? (float) request('center_lat') : 'null' }};
            const rLng = {{ request('center_lng') ? (float) request('center_lng') : 'null' }};
            const rKm = {{ request('radius_km') ? (float) request('radius_km') : 'null' }};
            
            if (rLat !== null && rLng !== null && rKm !== null && rKm > 0) {
                L.circle([rLat, rLng], {
                    radius: rKm * 1000,
                    color: '#15803d',
                    fillColor: '#22c55e',
                    fillOpacity: 0.2
                }).addTo(map);
                map.setView([rLat, rLng], 13);
            }
            
            // Force map resize after a short delay
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
            
            console.log('Map initialized successfully');
            
        } catch (error) {
            console.error('Error initializing map:', error);
        }
    });
</script>
@endsection
