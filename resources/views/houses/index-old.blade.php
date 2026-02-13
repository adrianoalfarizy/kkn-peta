@php($title = 'Data Rumah Warga')
@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <section class="rounded-xl border border-orange-200 bg-white">
        <div class="relative h-48 md:h-72 lg:h-96 overflow-hidden rounded-t-xl">
            <img src="{{ asset('images/gunungsari.jpg') }}" alt="Desa Gunungsari, Dawarblandong, Mojokerto" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&auto=format&fit=crop&w=1600&h=400'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-black/10"></div>
            <div class="absolute inset-x-0 bottom-0 p-4 md:p-6 text-white">
                <div class="text-xs">Peta Desa</div>
                <h2 class="text-2xl md:text-3xl font-semibold">Desa Gunungsari</h2>
                <div class="text-sm">Kecamatan Dawarblandong, Kabupaten Mojokerto</div>
            </div>
        </div>
        <div class="p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <p class="text-sm leading-relaxed text-neutral-700">Pemetaan rumah warga membantu perencanaan program, distribusi bantuan, serta mitigasi kebencanaan berbasis data lokasi.</p>
                <div class="flex items-center gap-2">
                    <a href="#data" class="h-9 rounded-md bg-orange-600 px-4 text-sm font-medium text-white hover:bg-orange-700 inline-flex items-center">Lihat Data</a>
                    @auth
                        <a href="{{ route('houses.create') }}" class="h-9 rounded-md border border-neutral-300 px-4 text-sm font-medium hover:bg-neutral-100 inline-flex items-center">Tambah Titik</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-xl font-semibold">Data Rumah Warga</h1>
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('houses.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari alamat..." class="h-9 rounded-md border border-neutral-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                <button type="submit" class="h-9 rounded-md bg-orange-600 px-4 text-sm font-medium text-white hover:bg-orange-700">Cari</button>
            </form>
            @auth
                <a href="{{ route('houses.create') }}" class="h-9 rounded-md bg-neutral-900 px-4 text-sm font-medium text-white hover:bg-neutral-800 inline-flex items-center">Tambah Rumah</a>
                <a href="{{ route('houses.export') }}" class="h-9 rounded-md border border-neutral-300 px-4 text-sm font-medium hover:bg-neutral-100 inline-flex items-center">Ekspor CSV</a>
            @endauth
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="rounded-md border border-neutral-200 bg-white p-3 space-y-2">
            <div class="text-sm font-medium">Filter Radius</div>
            <form method="GET" action="{{ route('houses.index') }}" class="space-y-2">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-neutral-600">Center Lat</label>
                        <input id="center_lat" type="text" name="center_lat" value="{{ request('center_lat') }}" class="w-full rounded-md border border-neutral-300 px-2 py-1 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-neutral-600">Center Lng</label>
                        <input id="center_lng" type="text" name="center_lng" value="{{ request('center_lng') }}" class="w-full rounded-md border border-neutral-300 px-2 py-1 text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-neutral-600">Radius (km)</label>
                    <input id="radius_km" type="number" step="0.1" min="0" name="radius_km" value="{{ request('radius_km') }}" class="w-full rounded-md border border-neutral-300 px-2 py-1 text-sm">
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="useMapCenter()" class="h-8 rounded-md border border-neutral-300 px-3 text-xs hover:bg-neutral-100">Gunakan Titik Peta</button>
                    <button type="submit" class="h-8 rounded-md bg-orange-600 px-3 text-xs font-medium text-white hover:bg-orange-700">Terapkan</button>
                </div>
            </form>
        </div>
        <div class="md:col-span-2">
            <div id="map" class="h-72 w-full rounded-md border border-neutral-200"></div>
        </div>
    </div>

    <div id="data" class="overflow-x-auto rounded-md border border-neutral-200">
        <div class="flex items-center justify-between p-3">
            <div class="text-sm text-neutral-600">Menampilkan {{ $houses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $houses->count() : count($houses) }} dari total {{ $houses instanceof \Illuminate\Pagination\LengthAwarePaginator ? $houses->total() : count($houses) }} data</div>
            <form method="GET" action="{{ route('houses.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="center_lat" value="{{ request('center_lat') }}">
                <input type="hidden" name="center_lng" value="{{ request('center_lng') }}">
                <input type="hidden" name="radius_km" value="{{ request('radius_km') }}">
                <label class="text-xs text-neutral-600">Per halaman</label>
                <select name="per_page" class="rounded-md border border-neutral-300 px-2 py-1 text-sm" onchange="this.form.submit()">
                    @foreach([10,25,50] as $size)
                        <option value="{{ $size }}" {{ (int)request('per_page', 10) === $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50 sticky top-14">
                <tr>
                    <th class="py-2 px-3 text-left text-xs font-medium text-neutral-600">ID</th>
                    <th class="py-2 px-3 text-left text-xs font-medium text-neutral-600">Alamat</th>
                    <th class="py-2 px-3 text-left text-xs font-medium text-neutral-600">Koordinat</th>
                    <th class="py-2 px-3 text-left text-xs font-medium text-neutral-600">Dibuat</th>
                    <th class="py-2 px-3 text-left text-xs font-medium text-neutral-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white">
                @forelse($houses as $house)
                    <tr class="hover:bg-neutral-50">
                        <td class="py-2 px-3 text-sm">{{ $house->id }}</td>
                        <td class="py-2 px-3 text-sm">{{ $house->alamat }}</td>
                        <td class="py-2 px-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs bg-neutral-100 px-2 py-1 rounded">{{ $house->latitude }}, {{ $house->longitude }}</span>
                                <button type="button" class="rounded-md border border-neutral-300 px-2 py-1 text-xs hover:bg-neutral-100" onclick="navigator.clipboard.writeText('{{ $house->latitude }},{{ $house->longitude }}')">Salin</button>
                            </div>
                        </td>
                        <td class="py-2 px-3 text-sm">{{ \Illuminate\Support\Carbon::parse($house->created_at)->format('d M Y, H:i') }}</td>
                        <td class="py-2 px-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('houses.show', $house) }}" class="rounded-md border border-neutral-300 px-3 py-1 text-xs hover:bg-neutral-100">Lihat</a>
                                @auth
                                    <a href="{{ route('houses.edit', $house) }}" class="rounded-md border border-neutral-300 px-3 py-1 text-xs hover:bg-neutral-100">Edit</a>
                                    <form action="{{ route('houses.destroy', $house) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md border border-red-300 px-3 py-1 text-xs text-red-700 hover:bg-red-50">Hapus</button>
                                    </form>
                                @endauth
                                <button type="button" class="rounded-md border border-neutral-300 px-3 py-1 text-xs hover:bg-neutral-100" onclick="focusMarker({{ $house->latitude }}, {{ $house->longitude }})">Peta</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-3 text-center text-sm text-neutral-600">Belum ada data rumah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($houses, 'links'))
        <div class="flex items-center justify-between">
            {{ $houses->links('pagination::tailwind') }}
        </div>
    @endif

    @if(session('status'))
        <script>
            showToast('{{ session('status') }}', 'success');
        </script>
    @endif

    @auth
        <div class="mt-3 rounded-md border border-neutral-200 bg-white p-3">
            <div class="text-sm font-medium mb-2">Import CSV</div>
            <form id="importForm" action="{{ route('houses.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="file" name="csv" accept=".csv,text/csv" required class="text-sm">
                <button type="submit" class="h-9 rounded-md bg-neutral-900 px-4 text-sm font-medium text-white hover:bg-neutral-800 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Import</span>
                    <span class="btn-loading hidden">Memproses...</span>
                </button>
            </form>
            <div class="mt-2 text-xs text-neutral-600">Format kolom: alamat, latitude, longitude. Baris pertama boleh header.</div>
        </div>

        <script>
            document.getElementById('importForm').addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.querySelector('.btn-text').classList.add('hidden');
                btn.querySelector('.btn-loading').classList.remove('hidden');
            });
        </script>
    @endauth

    <section id="tentang" class="mt-6 rounded-xl border border-neutral-200 bg-white p-5">
        <h3 class="text-lg font-semibold">Tentang Desa Gunungsari</h3>
        <p class="mt-2 text-sm leading-relaxed text-neutral-700">Desa Gunungsari berada di wilayah Kecamatan Dawarblandong, Kabupaten Mojokerto. Wilayah desa ditopang oleh sektor pertanian dan peternakan dengan komunitas warga yang guyub. Dengan adanya peta rumah warga, perangkat desa dan tim KKN dapat melakukan analisis sebaran, menentukan prioritas program, dan meningkatkan koordinasi layanan publik.</p>
        <p class="mt-2 text-sm leading-relaxed text-neutral-700">Pemetaan ini dikembangkan sederhana dengan Leaflet dan data yang dapat diekspor maupun diimpor untuk integrasi lebih lanjut. Ke depan, peta dapat dikembangkan untuk fitur seperti heatmap kepadatan, zona rawan banjir, atau penandaan fasilitas umum untuk mendukung perencanaan desa.</p>
    </section>

    <section id="panduan" class="mt-6 rounded-xl border border-blue-200 bg-blue-50 p-5">
        <h3 class="text-lg font-semibold text-blue-900">📖 Panduan Penggunaan</h3>
        <div class="mt-3 space-y-3 text-sm text-blue-900">
            <div>
                <div class="font-medium">1. Login Admin</div>
                <p class="text-blue-800">Gunakan akun: <code class="bg-blue-100 px-2 py-0.5 rounded">admin@gunungsari.id</code> / <code class="bg-blue-100 px-2 py-0.5 rounded">password123</code></p>
                <p class="text-blue-800 text-xs mt-1">⚠️ Segera ganti password setelah login pertama kali!</p>
            </div>
            <div>
                <div class="font-medium">2. Menambah Data Rumah</div>
                <p class="text-blue-800">Klik "Tambah Rumah" → Isi alamat → Klik pada peta untuk menentukan lokasi → Simpan</p>
            </div>
            <div>
                <div class="font-medium">3. Import Data CSV</div>
                <p class="text-blue-800">Format file: alamat, latitude, longitude (baris pertama boleh header)</p>
                <p class="text-blue-800 text-xs mt-1">Contoh: Jl. Raya Gunungsari No. 1, -7.123456, 112.654321</p>
            </div>
            <div>
                <div class="font-medium">4. Export Data</div>
                <p class="text-blue-800">Klik "Ekspor CSV" untuk backup atau analisis data di Excel/Google Sheets</p>
            </div>
            <div>
                <div class="font-medium">5. Filter Radius</div>
                <p class="text-blue-800">Gunakan filter radius untuk mencari rumah dalam jarak tertentu dari titik pusat</p>
            </div>
        </div>
    </section>

    <section id="disclaimer" class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-5">
        <h3 class="text-lg font-semibold text-amber-900">⚠️ Disclaimer & Kebijakan Privasi</h3>
        <div class="mt-3 space-y-2 text-sm text-amber-900">
            <p><strong>Kepemilikan Data:</strong> Seluruh data dalam sistem ini adalah milik Kelurahan Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto.</p>
            <p><strong>Penggunaan Data:</strong> Data hanya digunakan untuk keperluan administrasi kelurahan, perencanaan program, dan pelayanan publik. Dilarang menyebarluaskan data tanpa izin resmi dari pihak kelurahan.</p>
            <p><strong>Keamanan Data:</strong> Admin bertanggung jawab menjaga kerahasiaan akun login. Segera hubungi pengembang jika terjadi masalah keamanan.</p>
            <p><strong>Akurasi Data:</strong> Koordinat GPS bersifat estimasi. Untuk keperluan legal/resmi, mohon verifikasi langsung ke lapangan.</p>
            <p><strong>Backup Data:</strong> Disarankan melakukan export data secara berkala (minimal 1 bulan sekali) sebagai backup.</p>
            <p><strong>Support:</strong> Untuk bantuan teknis atau pertanyaan, hubungi tim pengembang KKN atau IT Kelurahan.</p>
        </div>
    </section>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
    const points = @json($points);
    const defaultLat = points.length ? points[0].lat : -6.9;
    const defaultLng = points.length ? points[0].lng : 107.6;
    const map = L.map('map').setView([defaultLat, defaultLng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    const cluster = L.markerClusterGroup();
    points.forEach(p => {
        const m = L.marker([p.lat, p.lng]).bindPopup(`<strong>${p.alamat}</strong><br>Lat: ${p.lat}<br>Lng: ${p.lng}`);
        cluster.addLayer(m);
    });
    map.addLayer(cluster);
    window.focusMarker = function(lat, lng) {
        map.setView([lat, lng], 17);
    };
    function useMapCenter() {
        const c = map.getCenter();
        document.getElementById('center_lat').value = c.lat.toFixed(7);
        document.getElementById('center_lng').value = c.lng.toFixed(7);
    }
    const rLat = {{ request('center_lat') ? (float) request('center_lat') : 'null' }};
    const rLng = {{ request('center_lng') ? (float) request('center_lng') : 'null' }};
    const rKm = {{ request('radius_km') ? (float) request('radius_km') : 'null' }};
    if (rLat !== null && rLng !== null && rKm !== null && rKm > 0) {
        L.circle([rLat, rLng], { radius: rKm * 1000, color: '#FF750F' }).addTo(map);
        map.setView([rLat, rLng], 14);
    }
</script>
@endsection
