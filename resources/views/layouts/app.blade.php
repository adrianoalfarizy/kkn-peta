<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sistem Peta Desa Gunungsari' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Inter', sans-serif; }
        .logo-navbar { height: 38px; }
        .logo-hero-campus { height: 52px; }
        .logo-hero-kkn { height: 48px; }
        .logo-footer { height: 32px; }
        @media (max-width: 768px) {
            .logo-navbar { height: 32px; }
            .logo-hero-campus { height: 44px; }
            .logo-hero-kkn { height: 40px; }
            .logo-footer { height: 28px; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navbar Fixed -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-green-800 to-green-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-kecamatan.jpg') }}" alt="Logo Kecamatan" class="logo-navbar h-9 w-auto object-contain">
                    <div class="hidden md:block">
                        <div class="text-white font-bold text-lg">Desa Gunungsari</div>
                        <div class="text-green-200 text-xs">Kec. Dawarblandong, Kab. Mojokerto</div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('houses.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('houses.*') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                        Rumah
                    </a>
                    <a href="{{ route('umkms.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('umkms.*') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/></svg>
                        UMKM
                    </a>
                    @auth
                        @if(auth()->user()->hasAnyRole(['super_admin','admin_desa']))
                            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM2 18a6 6 0 0112 0H2zM14 7a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2h12z"/></svg>
                                Manajemen User
                            </a>
                        @endif
                    @endauth
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('residents.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('residents.*') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/></svg>
                            Data Warga
                        </a>
                        <a href="{{ route('debts.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('debts.*') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                            Utang Warga
                        </a>
                        <a href="{{ route('houses.create') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('houses.create') ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700' }}">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                            Tambah Data
                        </a>
                        <a href="{{ route('houses.export') }}" class="px-4 py-2 rounded-md text-sm font-medium text-green-100 hover:bg-green-700">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            Ekspor
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-red-200 hover:bg-red-700 hover:text-white">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium bg-white text-green-800 hover:bg-green-50">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Login Admin
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" class="text-green-100 hover:text-white" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-green-900">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('houses.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Data Rumah</a>
                <a href="{{ route('umkms.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Data UMKM</a>
                        @auth
                            @if(auth()->user()->hasAnyRole(['super_admin','admin_desa']))
                                <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Manajemen User</a>
                            @endif
                        @endauth
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Dashboard</a>
                    <a href="{{ route('residents.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Data Warga</a>
                    <a href="{{ route('debts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Utang Warga</a>
                    <a href="{{ route('houses.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Tambah Rumah</a>
                    <a href="{{ route('umkms.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Tambah UMKM</a>
                    <a href="{{ route('houses.export') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-green-800">Ekspor</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-200 hover:bg-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-white text-green-800">Login Admin</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-900 to-green-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Logo Institusi -->
            <div class="flex flex-wrap items-center justify-center gap-6 md:gap-8 mb-8 pb-6 border-b border-green-700">
                <img src="{{ asset('images/logo-umg.png') }}" alt="Logo Kampus" class="logo-footer h-8 w-auto object-contain opacity-90 hover:opacity-100 transition">
                <img src="{{ asset('images/logo-kecamatan.jpg') }}" alt="Logo Kecamatan" class="logo-footer h-8 w-auto object-contain opacity-90 hover:opacity-100 transition">
                <img src="{{ asset('images/logo-kelompok.png') }}" alt="Logo Kelompok KKN" class="logo-footer h-8 w-auto object-contain opacity-90 hover:opacity-100 transition">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Info -->
                <div>
                    <div class="font-bold text-lg mb-2">Sistem Informasi Peta Rumah Warga</div>
                    <div class="text-green-200 text-sm mb-3">Desa Gunungsari - Kec. Dawarblandong</div>
                    <p class="text-green-200 text-sm">Sistem untuk mendukung pendataan dan perencanaan program desa.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Menu Cepat</h3>
                    <ul class="space-y-2 text-green-200 text-sm">
                        <li><a href="{{ route('houses.index') }}" class="hover:text-white">→ Beranda</a></li>
                        <li><a href="{{ route('houses.index') }}#peta" class="hover:text-white">→ Peta Desa</a></li>
                        <li><a href="{{ route('houses.index') }}#data" class="hover:text-white">→ Data Rumah</a></li>
                        <li><a href="{{ route('houses.index') }}#panduan" class="hover:text-white">→ Panduan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Kontak</h3>
                    <div class="space-y-2 text-green-200 text-sm">
                        <p>📍 Desa Gunungsari, Kec. Dawarblandong</p>
                        <p>📞 Telp: 0858-7678-57458</p>
                        <p>✉️ Email: gunungsari@mojokertokab.go.id</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-green-700 mt-8 pt-6 text-center text-green-200 text-sm">
                <p class="mb-1">&copy; {{ date('Y') }} Desa Gunungsari, Kecamatan Dawarblandong, Kabupaten Mojokerto</p>
                <p class="text-xs">Program Kuliah Kerja Nyata - Dikembangkan oleh Tim KKN</p>
            </div>
        </div>
    </footer>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                info: 'bg-blue-600'
            };
            toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-xl flex items-center gap-3 min-w-[320px] animate-slide-in`;
            toast.innerHTML = `
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="flex-1 font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            `;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }
    </script>
    <style>
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in { animation: slide-in 0.3s ease-out; }
    </style>
</body>
</html>
