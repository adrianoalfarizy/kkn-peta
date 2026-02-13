@php($title = 'Edit Data UMKM')
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Edit Data UMKM</h1>
            <p class="text-blue-100 text-sm mt-1">{{ $umkm->nama_usaha }}</p>
        </div>

        <form action="{{ route('umkms.update', $umkm) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_usaha" class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha *</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_usaha') border-red-500 @enderror">
                    @error('nama_usaha')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pemilik" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik *</label>
                    <input type="text" id="pemilik" name="pemilik" value="{{ old('pemilik', $umkm->pemilik) }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pemilik') border-red-500 @enderror">
                    @error('pemilik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select id="kategori" name="kategori" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori', $umkm->kategori) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="aktif" {{ old('status', $umkm->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $umkm->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="tutup" {{ old('status', $umkm->status) == 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @auth
                    @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin_desa')
                    <div>
                        <label for="status_verifikasi" class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                        <select id="status_verifikasi" name="status_verifikasi" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status_verifikasi') border-red-500 @enderror">
                            <option value="menunggu" {{ old('status_verifikasi', $umkm->status_verifikasi) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="disetujui" {{ old('status_verifikasi', $umkm->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ old('status_verifikasi', $umkm->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status_verifikasi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                @endauth
            </div>

            <!-- Address -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                <textarea id="alamat" name="alamat" rows="3" required 
                          placeholder="Contoh: Jl. Raya Gunungsari, Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto, Jawa Timur"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror">{{ old('alamat', $umkm->alamat) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">💡 <strong>Format untuk pencarian koordinat:</strong> Gunakan format lengkap (Desa, Kecamatan, Kabupaten). Jika alamat tidak ditemukan, klik langsung pada peta.</p>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">Kontak (HP/WA)</label>
                    <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $umkm->kontak) }}" 
                           placeholder="08123456789"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kontak') border-red-500 @enderror">
                    @error('kontak')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_operasional" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                    <input type="text" id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional', $umkm->jam_operasional) }}" 
                           placeholder="08:00 - 17:00"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_operasional') border-red-500 @enderror">
                    @error('jam_operasional')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Usaha</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" 
                          placeholder="Deskripsi produk/jasa yang ditawarkan..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto Usaha</label>
                @if($umkm->foto)
                    <div class="mb-4">
                        <img src="{{ Storage::url($umkm->foto) }}" alt="Foto UMKM" class="w-32 h-32 object-cover rounded-lg border">
                        <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                    </div>
                @endif
                <input type="file" id="foto" name="foto" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('foto') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG/WEBP. Maksimal 5MB</p>
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi UMKM</h3>
                <p class="text-sm text-gray-600 mb-4">Klik pada peta untuk mengubah lokasi UMKM, atau masukkan koordinat secara manual</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude *</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $umkm->latitude) }}" required 
                               placeholder="-7.123456"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latitude') border-red-500 @enderror">
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude *</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $umkm->longitude) }}" required 
                               placeholder="112.654321"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('longitude') border-red-500 @enderror">
                        @error('longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- GPS Button -->
                <div class="mb-6">
                    <button type="button" id="getLocationBtn" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        Gunakan Lokasi Saya
                    </button>
                    <div class="mt-2 text-sm text-gray-600">
                        <p class="mb-1">💡 <strong>Tips GPS Akurat:</strong></p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Pastikan GPS/Location Services aktif di perangkat</li>
                            <li>Gunakan di area terbuka, hindari dalam ruangan</li>
                            <li>Tunggu beberapa detik untuk akurasi terbaik</li>
                            <li>Akurasi terbaik: &lt;10 meter</li>
                        </ul>
                    </div>
                </div>

                <!-- Map -->
                <div id="map" class="w-full h-96 rounded-lg border-2 border-gray-300"></div>
                <p class="text-sm text-gray-500 mt-2">Klik pada peta untuk mengubah lokasi UMKM</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Update Data UMKM
                </button>
                <a href="{{ route('umkms.index') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-center">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Map Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize map with existing coordinates
    const initialLat = {{ $umkm->latitude }};
    const initialLng = {{ $umkm->longitude }};
    const map = L.map('map').setView([initialLat, initialLng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add existing marker
    let marker = L.marker([initialLat, initialLng]).addTo(map);
    marker.bindPopup(`{{ $umkm->nama_usaha }}<br>Lat: ${initialLat}<br>Lng: ${initialLng}`);
    
    // Fix map size for long forms
    setTimeout(() => {
        map.invalidateSize();
    }, 300);
    
    // GPS Location function
    document.getElementById('getLocationBtn').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>Mencari Lokasi...';
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude.toFixed(7);
                    const lng = position.coords.longitude.toFixed(7);
                    
                    // Update input fields
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    
                    // Remove existing marker
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    
                    // Add new marker
                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 16);
                    
                    // Reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.display_name || 'Alamat tidak ditemukan';
                            marker.bindPopup(`
                                <div class="p-2">
                                    <div class="font-bold text-green-800 mb-1">{{ $umkm->nama_usaha }}</div>
                                    <div class="text-sm text-gray-600 mb-2">${address}</div>
                                    <div class="text-xs text-gray-500">
                                        <div>Lat: ${lat}</div>
                                        <div>Lng: ${lng}</div>
                                        <div class="mt-1 text-green-600">✓ GPS Akurat: ${position.coords.accuracy.toFixed(0)}m</div>
                                    </div>
                                </div>
                            `).openPopup();
                        })
                        .catch(() => {
                            marker.bindPopup(`
                                <div class="p-2">
                                    <div class="font-bold text-green-800 mb-1">{{ $umkm->nama_usaha }}</div>
                                    <div class="text-xs text-gray-500">
                                        <div>Lat: ${lat}</div>
                                        <div>Lng: ${lng}</div>
                                        <div class="mt-1 text-green-600">✓ GPS Akurat: ${position.coords.accuracy.toFixed(0)}m</div>
                                    </div>
                                </div>
                            `).openPopup();
                        });
                    
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Gunakan Lokasi Saya';
                },
                function(error) {
                    alert('Tidak dapat mengakses lokasi GPS.');
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Gunakan Lokasi Saya';
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        }
    });
    
    // Map click handler with reverse geocoding
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(7);
        const lng = e.latlng.lng.toFixed(7);
        
        // Update input fields
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }
        
        // Add new marker
        marker = L.marker([lat, lng]).addTo(map);
        
        // Reverse geocoding
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                const address = data.display_name || 'Alamat tidak ditemukan';
                marker.bindPopup(`
                    <div class="p-2">
                        <div class="font-bold text-blue-800 mb-1">{{ $umkm->nama_usaha }}</div>
                        <div class="text-sm text-gray-600 mb-2">${address}</div>
                        <div class="text-xs text-gray-500">
                            <div>Lat: ${lat}</div>
                            <div>Lng: ${lng}</div>
                        </div>
                    </div>
                `).openPopup();
            })
            .catch(() => {
                marker.bindPopup(`{{ $umkm->nama_usaha }}<br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
            });
    });
    
    // Update marker when coordinates are manually entered
    function updateMarker() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        
        if (!isNaN(lat) && !isNaN(lng)) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup(`{{ $umkm->nama_usaha }}<br>Lat: ${lat}<br>Lng: ${lng}`);
            map.setView([lat, lng], 15);
        }
    }
    
    document.getElementById('latitude').addEventListener('blur', updateMarker);
    document.getElementById('longitude').addEventListener('blur', updateMarker);
});
</script>
@endsection
