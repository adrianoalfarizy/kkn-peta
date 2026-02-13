@php($title = 'Edit Rumah')
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Data Rumah</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('houses.update', $house) }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat <span class="text-red-500">*</span></label>
                    <input type="text" name="alamat" value="{{ old('alamat', $house->alamat) }}" required minlength="5" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <div class="text-xs text-gray-500">Minimal 5 karakter</div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Nomor KK</label>
                    <input type="text" name="no_kk" value="{{ old('no_kk', $house->no_kk) }}" maxlength="16" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: 3507012345678901">
                    <div class="text-xs text-gray-500">Opsional, maksimal 16 digit</div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Foto KK</label>
                    @if($house->foto_kk)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $house->foto_kk) }}" alt="Foto KK" class="h-40 rounded-lg border-2 border-gray-200">
                            <div class="text-xs text-gray-500 mt-2">Foto saat ini</div>
                        </div>
                    @endif
                    <input id="foto_kk" type="file" name="foto_kk" accept="image/*" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <div class="text-xs text-gray-500">Opsional, format: JPG/PNG/WEBP, maksimal 5MB. Kosongkan jika tidak ingin mengubah.</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="Aktif" {{ old('status', $house->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $house->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="Pindah" {{ old('status', $house->status) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Bantuan</label>
                        <textarea name="bantuan" rows="3" class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: PKH, BPNT, Bantuan Sembako">{{ old('bantuan', $house->bantuan) }}</textarea>
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
                    <div class="text-xs text-orange-600">Klik pada peta untuk mengubah lokasi rumah atau gunakan tombol GPS</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Latitude <span class="text-red-500">*</span></label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude', $house->latitude) }}" required class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Longitude <span class="text-red-500">*</span></label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude', $house->longitude) }}" required class="rounded-md border border-gray-300 px-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2.5 rounded-md bg-green-700 text-white font-medium hover:bg-green-800 transition">
                        <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Update Data
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
        const initLat = {{ $house->latitude ?? -7.5 }};
        const initLng = {{ $house->longitude ?? 112.5 }};
        const map = L.map('map').setView([initLat, initLng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        let marker = L.marker([initLat, initLng]).addTo(map);

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
                        
                        // Update marker popup
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
</div>
@endsection
