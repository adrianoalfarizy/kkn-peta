@php($title = $umkm->nama_usaha)
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-blue-700 px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $umkm->nama_usaha }}</h1>
                    <p class="text-blue-100 text-sm mt-1">Detail Informasi UMKM</p>
                </div>
                <div class="flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('umkms.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                        Kembali
                    </a>
                    @auth
                        <a href="{{ route('umkms.edit', $umkm) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                            Edit
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Dasar</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Usaha</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $umkm->nama_usaha }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pemilik</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $umkm->pemilik }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $umkm->kategori_label }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $umkm->status == 'aktif' ? 'bg-green-100 text-green-800' : ($umkm->status == 'tidak_aktif' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $umkm->status_label }}
                        </span>
                    </div>
                    @auth
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status Verifikasi</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $umkm->status_verifikasi == 'disetujui' ? 'bg-green-100 text-green-800' : ($umkm->status_verifikasi == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $umkm->status_verifikasi_label }}
                            </span>
                        </div>
                    @endauth
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Input</label>
                        <p class="text-gray-900">{{ $umkm->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact & Hours -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Kontak & Operasional</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kontak</label>
                        @if($umkm->kontak)
                            <div class="flex items-center gap-2">
                                <p class="text-gray-900">{{ $umkm->kontak }}</p>
                                @if(str_starts_with($umkm->kontak, '08') || str_starts_with($umkm->kontak, '+62'))
                                    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $umkm->kontak) }}" target="_blank" 
                                       class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs rounded hover:bg-green-200 transition">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 italic">Tidak ada kontak</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jam Operasional</label>
                        <p class="text-gray-900">{{ $umkm->jam_operasional ?: 'Tidak diketahui' }}</p>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Alamat</h2>
                <p class="text-gray-900 leading-relaxed">{{ $umkm->alamat }}</p>
                <div class="mt-4 flex items-center gap-4 text-sm text-gray-500">
                    <span>Koordinat: {{ $umkm->latitude }}, {{ $umkm->longitude }}</span>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $umkm->latitude }},{{ $umkm->longitude }}'); showToast('Koordinat disalin!', 'success')" 
                            class="text-blue-600 hover:text-blue-800">
                        <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/><path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/></svg>
                        Salin
                    </button>
                </div>
            </div>

            <!-- Description -->
            @if($umkm->deskripsi)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Usaha</h2>
                <p class="text-gray-900 leading-relaxed">{{ $umkm->deskripsi }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Photo -->
            @if($umkm->foto)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Foto Usaha</h3>
                <img src="{{ Storage::url($umkm->foto) }}" alt="{{ $umkm->nama_usaha }}" 
                     class="w-full h-48 object-cover rounded-lg border">
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <button type="button" onclick="focusMap()" 
                            class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        Lihat di Peta
                    </button>
                    
                    @if($umkm->kontak && (str_starts_with($umkm->kontak, '08') || str_starts_with($umkm->kontak, '+62')))
                    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $umkm->kontak) }}" target="_blank"
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                        Hubungi via WhatsApp
                    </a>
                    @endif

                    @auth
                    <a href="{{ route('umkms.edit', $umkm) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                        Edit Data
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Dibuat</span>
                        <span class="text-sm font-medium">{{ $umkm->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Diupdate</span>
                        <span class="text-sm font-medium">{{ $umkm->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">ID</span>
                        <span class="text-sm font-medium">#{{ $umkm->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Lokasi di Peta</h2>
        <div id="map" class="w-full h-96 rounded-lg border"></div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Map Script -->
<script>
    // Initialize map
    const lat = {{ $umkm->latitude }};
    const lng = {{ $umkm->longitude }};
    const map = L.map('map').setView([lat, lng], 16);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Custom icon for UMKM
    const umkmIcon = L.divIcon({
        html: '<div style="background-color: #3B82F6; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.4);"></div>',
        className: 'custom-div-icon',
        iconSize: [24, 24],
        iconAnchor: [12, 12]
    });
    
    // Add marker
    const marker = L.marker([lat, lng], {icon: umkmIcon}).addTo(map);
    marker.bindPopup(`
        <div class="p-3 min-w-[200px]">
            <div class="font-bold text-blue-800 mb-2">{{ $umkm->nama_usaha }}</div>
            <div class="text-sm text-gray-600 mb-1">{{ $umkm->pemilik }}</div>
            <div class="text-sm text-blue-600 mb-2">{{ $umkm->kategori_label }}</div>
            <div class="text-xs text-gray-500">{{ $umkm->alamat }}</div>
        </div>
    `).openPopup();
    
    // Focus map function
    window.focusMap = function() {
        document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => {
            map.invalidateSize();
            marker.openPopup();
        }, 500);
    };
</script>
@endsection