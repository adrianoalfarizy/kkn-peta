@php($title = 'Detail Rumah')

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold">Detail Rumah #{{ $house->id }}</h1>
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('houses.edit', $house) }}"
                        class="h-9 rounded-md border border-neutral-300 px-4 text-sm font-medium hover:bg-neutral-100 inline-flex items-center">Edit</a>
                @endauth
                <a href="{{ route('houses.index') }}"
                    class="h-9 rounded-md border border-neutral-300 px-4 text-sm font-medium hover:bg-neutral-100 inline-flex items-center">Kembali</a>
            </div>
        </div>

        <div class="rounded-md border border-neutral-200 bg-white p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-xs text-neutral-600">Alamat</div>
                    <div class="text-sm">{{ $house->alamat }}</div>
                </div>
                @auth
                    @if(auth()->user()->hasAnyRole(['super_admin', 'admin_desa']))
                        <div>
                            <div class="text-xs text-neutral-600">Nomor KK</div>
                            <div class="text-sm">{{ $house->no_kk ?: '-' }}</div>
                        </div>

                        @if($house->foto_kk)
                            <div>
                                <div class="text-xs text-neutral-600">Foto KK</div>
                                <a href="{{ route('houses.kk', $house) }}" target="_blank" rel="noopener">
                                    Lihat Foto KK (private)
                                </a>
                            </div>
                        @endif
                    @endif
                @endauth
                <div>
                    <div class="text-xs text-neutral-600">Koordinat</div>
                    <div class="text-sm">{{ $house->latitude }}, {{ $house->longitude }}</div>
                    <div class="mt-2 flex items-center gap-2">
                        <button type="button"
                            class="rounded-md border border-neutral-300 px-3 py-1 text-xs hover:bg-neutral-100"
                            onclick="copyCoords(); showToast('Koordinat berhasil disalin!', 'success')">Salin
                            Koordinat</button>
                        <a target="_blank"
                            class="rounded-md border border-neutral-300 px-3 py-1 text-xs hover:bg-neutral-100"
                            href="https://www.google.com/maps?q={{ $house->latitude }},{{ $house->longitude }}">Buka di
                            Google Maps</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="map" class="h-80 w-full rounded-md border border-neutral-200"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const lat = {{ (float) $house->latitude }};
        const lng = {{ (float) $house->longitude }};
        const map = L.map('map').setView([lat, lng], 17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup(`<strong>{{ $house->alamat }}</strong><br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
        function copyCoords() {
            const text = `${lat},${lng}`;
            navigator.clipboard.writeText(text);
        }
    </script>
@endsection