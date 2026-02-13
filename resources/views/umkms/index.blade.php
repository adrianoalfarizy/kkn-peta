@php($title = 'Data UMKM Desa Gunungsari')
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-700 to-green-600 text-white" style="background: linear-gradient(135deg, #15803d, #16a34a);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                Data UMKM Desa Gunungsari
            </h1>
            <p class="text-xl md:text-2xl text-green-100 mb-2" style="text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                Usaha Mikro Kecil Menengah
            </p>
            <p class="text-green-200 mb-6" style="text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                Kecamatan Dawarblandong, Kabupaten Mojokerto
            </p>
            
            <p class="text-lg text-green-100 max-w-3xl mx-auto mb-8" style="text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                Pemetaan dan pendataan UMKM untuk mendukung ekonomi lokal dan promosi usaha warga
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#peta" class="inline-flex items-center justify-center px-6 py-2.5 bg-white text-green-800 font-medium rounded-lg hover:bg-green-50 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Lihat Peta UMKM
                </a>
                @auth
                    <a href="{{ route('umkms.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-green-800 text-white font-medium rounded-lg hover:bg-green-900 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        Tambah UMKM
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ $umkms instanceof \Illuminate\Pagination\LengthAwarePaginator ? $umkms->total() : count($umkms) }}</div>
                        <div class="text-green-100 text-sm">Total UMKM</div>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ count($points) }}</div>
                        <div class="text-blue-100 text-sm">Titik Peta</div>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ count($categories) }}</div>
                        <div class="text-purple-100 text-sm">Kategori</div>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-3xl font-bold">{{ date('Y') }}</div>
                        <div class="text-orange-100 text-sm">Tahun Aktif</div>
                    </div>
                    <svg class="w-12 h-12 text-orange-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section id="peta" class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Peta Sebaran UMKM</h2>
            <p class="text-gray-600">Visualisasi lokasi UMKM Desa Gunungsari</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4 text-gray-900">Filter UMKM</h3>
            <form method="GET" action="{{ route('umkms.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama usaha/pemilik..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="tutup" {{ request('status') == 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Verifikasi</label>
                    <select name="status_verifikasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua</option>
                        <option value="menunggu" {{ request('status_verifikasi') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ request('status_verifikasi') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status_verifikasi') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Radius (km)</label>
                    <input id="radius_km" type="number" step="0.1" min="0" name="radius_km" value="{{ request('radius_km') }}" placeholder="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <input type="hidden" id="center_lat" name="center_lat" value="{{ request('center_lat') }}">
                    <input type="hidden" id="center_lng" name="center_lng" value="{{ request('center_lng') }}">
                </div>
                <div class="flex items-end gap-2">
                    <button type="button" onclick="useMapCenter()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Pusat Peta
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition">
                        Filter
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
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Data UMKM</h2>
                <p class="text-gray-600">Daftar lengkap UMKM yang terdata</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                @auth
                    <a href="{{ route('umkms.export') }}" class="inline-flex items-center justify-center px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
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
                    <thead class="bg-blue-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Usaha</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Verifikasi</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($umkms as $index => $umkm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($umkms instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($umkms->firstItem() + $index) : ($index + 1) }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $umkm->nama_usaha }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $umkm->pemilik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $umkm->kategori_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $umkm->status == 'aktif' ? 'bg-green-100 text-green-800' : ($umkm->status == 'tidak_aktif' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $umkm->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $umkm->status_verifikasi == 'disetujui' ? 'bg-green-100 text-green-800' : ($umkm->status_verifikasi == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $umkm->status_verifikasi_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('umkms.show', $umkm) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded hover:bg-blue-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                            Lihat
                                        </a>
                                        @auth
                                            <a href="{{ route('umkms.edit', $umkm) }}" class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded hover:bg-yellow-200 transition">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                                Edit
                                            </a>
                                            @if($umkm->status_verifikasi == 'menunggu' && (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin_desa'))
                                                <form action="{{ route('umkms.update', $umkm) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status_verifikasi" value="disetujui">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200 transition">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('umkms.destroy', $umkm) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data UMKM ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded hover:bg-red-200 transition">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endauth
                                        <button type="button" onclick="focusMarker({{ $umkm->latitude }}, {{ $umkm->longitude }})" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200 transition">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                            Peta
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada data UMKM</p>
                                    <p class="text-gray-400 text-sm mt-2">Silakan tambahkan data UMKM terlebih dahulu</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($umkms, 'links'))
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $umkms->links('pagination::tailwind') }}
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
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Import Data UMKM dari CSV</h3>
            <p class="text-gray-600 mb-6">Upload file CSV untuk menambahkan data UMKM secara massal</p>
            <form id="importForm" action="{{ route('umkms.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="file" name="csv" accept=".csv,text/csv" required class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="btn-text">Import Data</span>
                        <span class="btn-loading hidden">Memproses...</span>
                    </button>
                </div>
                <p class="text-sm text-gray-500">Format: nama_usaha, pemilik, kategori, alamat, latitude, longitude, kontak</p>
            </form>
        </div>
    </div>
</section>
@endauth

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
            
            console.log('UMKM Points:', points.length);
            
            const defaultLat = points.length ? points[0].lat : -7.5;
            const defaultLng = points.length ? points[0].lng : 112.5;
            
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
            
            const cluster = L.markerClusterGroup();
            
            // Custom icon for UMKM
            const umkmIcon = L.divIcon({
                html: '<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                className: 'custom-div-icon',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
            
            points.forEach(p => {
                const marker = L.marker([p.lat, p.lng], {icon: umkmIcon}).bindPopup(`
                    <div class="p-3 min-w-[250px]">
                        <div class="font-bold text-blue-800 mb-2 text-base">${p.nama_usaha}</div>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pemilik:</span>
                                <span class="font-medium">${p.pemilik}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-medium text-blue-600">${p.kategori}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium ${p.status === 'Aktif' ? 'text-green-600' : 'text-red-600'}">${p.status}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kontak:</span>
                                <span class="font-medium">${p.kontak}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jam:</span>
                                <span class="font-medium">${p.jam_operasional}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t">
                            <div class="text-xs text-gray-600">${p.alamat}</div>
                        </div>
                        <div class="mt-2 pt-2 border-t text-xs text-gray-500">
                            <div>Lat: ${p.lat}</div>
                            <div>Lng: ${p.lng}</div>
                        </div>
                    </div>
                `);
                cluster.addLayer(marker);
            });
            map.addLayer(cluster);
            
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
                    color: '#3B82F6',
                    fillColor: '#60A5FA',
                    fillOpacity: 0.2
                }).addTo(map);
                map.setView([rLat, rLng], 13);
            }
            
            // Force map resize after a short delay
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
            
            console.log('UMKM Map initialized successfully');
            
        } catch (error) {
            console.error('Error initializing UMKM map:', error);
        }
    });
</script>
@endsection