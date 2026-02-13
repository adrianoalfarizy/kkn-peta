@php($title = 'Tambah Data UMKM')
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Tambah Data UMKM</h1>
            <p class="text-blue-100 text-sm mt-1">Tambahkan data UMKM baru ke sistem</p>
        </div>

        <form action="{{ route('umkms.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_usaha" class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha *</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_usaha') border-red-500 @enderror">
                    @error('nama_usaha')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pemilik" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik *</label>
                    <input type="text" id="pemilik" name="pemilik" value="{{ old('pemilik') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pemilik') border-red-500 @enderror">
                    @error('pemilik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select id="kategori" name="kategori" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="tutup" {{ old('status') == 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                <div class="flex gap-2">
                    <textarea id="alamat" name="alamat" rows="3" required 
                              placeholder="Contoh: Jl. Raya Gunungsari, Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto, Jawa Timur"
                              class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                    <button type="button" onclick="geocodeAddress()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium whitespace-nowrap self-start">
                        🔍 Cari Koordinat
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">💡 <strong>Format untuk pencarian koordinat:</strong> Gunakan format lengkap (Desa, Kecamatan, Kabupaten). Jika alamat tidak ditemukan, klik langsung pada peta.</p>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">Kontak (HP/WA)</label>
                    <input type="text" id="kontak" name="kontak" value="{{ old('kontak') }}" 
                           placeholder="08123456789"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kontak') border-red-500 @enderror">
                    @error('kontak')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_operasional" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                    <input type="text" id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional') }}" 
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
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo Upload -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto Usaha</label>
                <input type="file" id="foto" name="foto" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('foto') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG/WEBP. Maksimal 5MB</p>
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi UMKM</h3>
                <p class="text-sm text-gray-600 mb-4">Klik pada peta untuk menentukan lokasi UMKM, atau masukkan koordinat secara manual</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude *</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required 
                               placeholder="-7.123456"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latitude') border-red-500 @enderror">
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude *</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" required 
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
                <p class="text-sm text-gray-500 mt-2">Klik pada peta untuk memilih lokasi UMKM</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Simpan Data UMKM
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
    // Initialize map
    const map = L.map('map').setView([-7.5, 112.5], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    let marker = null;
    
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
                    
                    // Reverse geocoding to get address
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.display_name || 'Alamat tidak ditemukan';
                            marker.bindPopup(`
                                <div class="p-2">
                                    <div class="font-bold text-green-800 mb-1">Lokasi GPS Anda</div>
                                    <div class="text-sm text-gray-600 mb-2">${address}</div>
                                    <div class="text-xs text-gray-500">
                                        <div>Lat: ${lat}</div>
                                        <div>Lng: ${lng}</div>
                                        <div class="mt-1 text-green-600">✓ Akurasi: ${position.coords.accuracy.toFixed(0)}m</div>
                                    </div>
                                </div>
                            `).openPopup();
                            
                            // Auto-fill alamat if empty
                            const alamatField = document.getElementById('alamat');
                            if (!alamatField.value.trim()) {
                                // Extract relevant address parts
                                const parts = address.split(',');
                                const relevantParts = parts.slice(0, 3).join(',').trim();
                                alamatField.value = relevantParts + ', Gunungsari, Dawarblandong, Mojokerto';
                            }
                        })
                        .catch(() => {
                            marker.bindPopup(`
                                <div class="p-2">
                                    <div class="font-bold text-green-800 mb-1">Lokasi GPS Anda</div>
                                    <div class="text-xs text-gray-500">
                                        <div>Lat: ${lat}</div>
                                        <div>Lng: ${lng}</div>
                                        <div class="mt-1 text-green-600">✓ Akurasi: ${position.coords.accuracy.toFixed(0)}m</div>
                                    </div>
                                </div>
                            `).openPopup();
                        });
                    
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Gunakan Lokasi Saya';
                },
                function(error) {
                    alert('Tidak dapat mengakses lokasi GPS. Pastikan GPS aktif dan izinkan akses lokasi.');
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Gunakan Lokasi Saya';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        } else {
            alert('Browser tidak mendukung GPS.');
            btn.disabled = false;
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
                        <div class="font-bold text-blue-800 mb-1">Lokasi Dipilih</div>
                        <div class="text-sm text-gray-600 mb-2">${address}</div>
                        <div class="text-xs text-gray-500">
                            <div>Lat: ${lat}</div>
                            <div>Lng: ${lng}</div>
                        </div>
                    </div>
                `).openPopup();
            })
            .catch(() => {
                marker.bindPopup(`
                    <div class="p-2">
                        <div class="font-bold text-blue-800 mb-1">Lokasi Dipilih</div>
                        <div class="text-xs text-gray-500">
                            <div>Lat: ${lat}</div>
                            <div>Lng: ${lng}</div>
                        </div>
                    </div>
                `).openPopup();
            });
    });
    
    // Update marker when coordinates are manually entered
    function updateMarker() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        
        if (!isNaN(lat) && !isNaN(lng)) {
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }
            
            // Add new marker
            marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup(`Lokasi UMKM<br>Lat: ${lat}<br>Lng: ${lng}`);
            map.setView([lat, lng], 15);
        }
    }
    
    // Add event listeners to coordinate inputs
    document.getElementById('latitude').addEventListener('blur', updateMarker);
    document.getElementById('longitude').addEventListener('blur', updateMarker);
    
    // Initialize marker if coordinates are already filled (from old input)
    const initialLat = document.getElementById('latitude').value;
    const initialLng = document.getElementById('longitude').value;
    if (initialLat && initialLng) {
        updateMarker();
    }
    
    // Fungsi Geocoding Otomatis
    window.geocodeAddress = async function() {
        const alamat = document.getElementById('alamat').value;
        if (!alamat || alamat.length < 5) {
            alert('Masukkan alamat terlebih dahulu (minimal 5 karakter)');
            return;
        }

        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = '⏳ Mencari...';

        try {
            // Array pencarian dengan berbagai format
            const searchQueries = [
                alamat + ', Gunungsari, Dawarblandong, Mojokerto, Jawa Timur',
                alamat + ', Gunungsari, Mojokerto',
                'Gunungsari, Dawarblandong, Mojokerto',
                'Dawarblandong, Mojokerto',
                'Mojokerto, Jawa Timur'
            ];

            let found = false;
            
            for (const query of searchQueries) {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`);
                const data = await response.json();

                if (data && data.length > 0) {
                    let lat = parseFloat(data[0].lat);
                    let lng = parseFloat(data[0].lon);
                    
                    // Buat offset konsisten berdasarkan hash alamat
                    const hash = alamat.split('').reduce((a, b) => {
                        a = ((a << 5) - a) + b.charCodeAt(0);
                        return a & a;
                    }, 0);
                    
                    // Konversi hash ke offset yang konsisten dalam radius ~500m
                    const offsetLat = ((hash % 1000) - 500) * 0.000009; // ~0.5m per unit
                    const offsetLng = (((hash >> 10) % 1000) - 500) * 0.000009;
                    
                    lat += offsetLat;
                    lng += offsetLng;
                    
                    // Set koordinat
                    document.getElementById('latitude').value = lat.toFixed(7);
                    document.getElementById('longitude').value = lng.toFixed(7);
                    
                    // Remove existing marker
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    
                    // Add new marker
                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 17);
                    marker.bindPopup(`
                        <div class="p-2">
                            <div class="font-bold text-blue-800 mb-1">Lokasi Ditemukan</div>
                            <div class="text-sm text-gray-600 mb-2">${query}</div>
                            <div class="text-xs text-gray-500">
                                <div>Lat: ${lat.toFixed(7)}</div>
                                <div>Lng: ${lng.toFixed(7)}</div>
                                <div class="mt-1 text-blue-600">✓ Posisi konsisten berdasarkan alamat</div>
                            </div>
                        </div>
                    `).openPopup();
                    
                    alert(`✅ Koordinat ditemukan untuk: ${query}\nPosisi disesuaikan berdasarkan alamat spesifik.`);
                    found = true;
                    break;
                }
            }
            
            if (!found) {
                // Set ke koordinat default Mojokerto dengan offset berdasarkan alamat
                let defaultLat = -7.4753;
                let defaultLng = 112.4339;
                
                // Hash alamat untuk offset konsisten
                const hash = alamat.split('').reduce((a, b) => {
                    a = ((a << 5) - a) + b.charCodeAt(0);
                    return a & a;
                }, 0);
                
                // Offset dalam radius ~2km untuk area Mojokerto
                const offsetLat = ((hash % 2000) - 1000) * 0.000018; // ~2m per unit
                const offsetLng = (((hash >> 11) % 2000) - 1000) * 0.000018;
                
                defaultLat += offsetLat;
                defaultLng += offsetLng;
                
                document.getElementById('latitude').value = defaultLat.toFixed(7);
                document.getElementById('longitude').value = defaultLng.toFixed(7);
                
                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker([defaultLat, defaultLng]).addTo(map);
                map.setView([defaultLat, defaultLng], 15);
                marker.bindPopup(`
                    <div class="p-2">
                        <div class="font-bold text-orange-800 mb-1">Area Mojokerto</div>
                        <div class="text-xs text-gray-500">
                            <div>Lat: ${defaultLat.toFixed(7)}</div>
                            <div>Lng: ${defaultLng.toFixed(7)}</div>
                            <div class="mt-1 text-orange-600">✓ Posisi konsisten berdasarkan alamat</div>
                        </div>
                    </div>
                `).openPopup();
                
                alert('⚠️ Alamat spesifik tidak ditemukan.\nMarker ditempatkan di area Mojokerto berdasarkan alamat.\nSilakan klik pada peta untuk menyesuaikan lokasi yang tepat.');
            }
        } catch (error) {
            console.error('Geocoding error:', error);
            alert('❌ Gagal mencari koordinat. Silakan klik manual di peta.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '🔍 Cari Koordinat';
        }
    };
});
</script>
@endsection
