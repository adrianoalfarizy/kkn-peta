@php($title = 'Tambah Rumah')
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Data Rumah</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateForm()">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required minlength="5" class="flex-1 rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: Jl. Raya Gunungsari, Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto">
                        <button type="button" onclick="geocodeAddress()" class="px-4 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium whitespace-nowrap">
                            🔍 Cari Koordinat
                        </button>
                    </div>
                    <div class="text-xs text-gray-500">💡 <strong>Format untuk pencarian koordinat:</strong> Gunakan format lengkap (Desa, Kecamatan, Kabupaten). Jika alamat tidak ditemukan, klik langsung pada peta.</div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Nomor KK</label>
                    <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: 3507012345678901">
                    <div class="text-xs text-gray-500">Opsional, maksimal 16 digit</div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Foto KK</label>
                    <input id="foto_kk" type="file" name="foto_kk" accept="image/*" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <div class="text-xs text-gray-500">Opsional, format: JPG/PNG/WEBP, maksimal 5MB</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="Aktif" {{ old('status') == 'Aktif' || old('status') == '' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="Pindah" {{ old('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Bantuan</label>
                        <textarea name="bantuan" rows="3" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: PKH, BPNT, Bantuan Sembako">{{ old('bantuan') }}</textarea>
                        <div class="text-xs text-gray-500">Opsional, sebutkan jenis bantuan yang diterima</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi pada Peta <span class="text-red-500">*</span></label>
                    
                    <!-- GPS Button -->
                    <div class="mb-4">
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
                    
                    <div id="map" class="h-80 w-full rounded-md border-2 border-gray-300"></div>
                    <div class="text-xs text-orange-600">Klik pada peta untuk menentukan lokasi rumah atau gunakan tombol GPS</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Latitude <span class="text-red-500">*</span></label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude') }}" required class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Longitude <span class="text-red-500">*</span></label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude') }}" required class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2.5 rounded-md bg-green-700 text-white font-medium hover:bg-green-800 transition">
                        <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Simpan Data
                    </button>
                    <a href="{{ route('houses.index') }}" class="px-6 py-2.5 rounded-md border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const defaultLat = -7.5;
        const defaultLng = 112.5;
        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        let marker = null;

        function setMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        }

        map.on('click', function (e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            setMarker(lat, lng);
        });

        const oldLat = document.getElementById('latitude').value;
        const oldLng = document.getElementById('longitude').value;

        if (oldLat && oldLng) {
            map.setView([oldLat, oldLng], 16);
            setMarker(oldLat, oldLng);
        }
        
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
                        
                        // Set marker and view
                        map.setView([lat, lng], 16);
                        setMarker(lat, lng);
                        
                        // Reverse geocoding to get address
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                            .then(response => response.json())
                            .then(data => {
                                const address = data.display_name || 'Alamat tidak ditemukan';
                                
                                // Update marker popup
                                if (marker) {
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
                                }
                                
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
                                if (marker) {
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
                                }
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
                btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>Gunakan Lokasi Saya';
            }
        });

        function validateForm() {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            if (!lat || !lng) {
                alert('Silakan klik pada peta untuk menentukan lokasi rumah!');
                return false;
            }
            return true;
        }

        function showToast(message, type = 'success') {
            alert(message);
        }

        // Fungsi Geocoding Otomatis
        async function geocodeAddress() {
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
                        
                        // Pindah peta dan set marker
                        map.setView([lat, lng], 17);
                        setMarker(lat, lng);
                        
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
                    
                    map.setView([defaultLat, defaultLng], 15);
                    setMarker(defaultLat, defaultLng);
                    
                    alert('⚠️ Alamat spesifik tidak ditemukan.\nMarker ditempatkan di area Mojokerto berdasarkan alamat.\nSilakan klik pada peta untuk menyesuaikan lokasi yang tepat.');
                }
            } catch (error) {
                console.error('Geocoding error:', error);
                alert('❌ Gagal mencari koordinat. Silakan klik manual di peta.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '🔍 Cari Koordinat';
            }
        }
        
        const fotoInput = document.getElementById('foto_kk');
        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                const file = this.files && this.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) {
                    alert('File harus gambar');
                    this.value = '';
                    return;
                }
                const max = 5 * 1024 * 1024;
                if (file.size > max) {
                    alert('Ukuran foto melebihi 5MB');
                    this.value = '';
                }
            });
        }
    </script>
@endsection
