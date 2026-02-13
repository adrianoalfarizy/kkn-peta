@php($title = 'Dashboard Statistik')
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Statistik Desa</h1>
            <p class="text-gray-600">Ringkasan data warga dan rumah Desa Gunungsari</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Warga -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-100" style="color: #dbeafe !important;">Total Warga</p>
                        <p class="text-4xl font-bold text-white" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ $totalWarga }}</p>
                    </div>
                    <div class="p-3 bg-blue-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total KK -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-100" style="color: #dcfce7 !important;">Total KK</p>
                        <p class="text-4xl font-bold text-white" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ $totalKK }}</p>
                    </div>
                    <div class="p-3 bg-green-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Warga Miskin -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-100" style="color: #fecaca !important;">Warga Miskin</p>
                        <p class="text-4xl font-bold text-white" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ $wargaMiskin }}</p>
                        <p class="text-xs text-red-200" style="color: #fecaca !important;">{{ $totalWarga > 0 ? round(($wargaMiskin / $totalWarga) * 100, 1) : 0 }}% dari total</p>
                    </div>
                    <div class="p-3 bg-red-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Penerima Bantuan -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-purple-100" style="color: #e9d5ff !important;">Penerima Bantuan</p>
                        <p class="text-4xl font-bold text-white" style="color: #ffffff !important; font-size: 2.5rem !important;">{{ $penerimaBantuan }}</p>
                        <p class="text-xs text-purple-200" style="color: #e9d5ff !important;">{{ $totalWarga > 0 ? round(($penerimaBantuan / $totalWarga) * 100, 1) : 0 }}% dari total</p>
                    </div>
                    <div class="p-3 bg-purple-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Utang -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                <p class="text-sm font-semibold text-orange-100">Total Utang</p>
                <p class="text-3xl font-bold">Rp {{ number_format($totalUtang ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <p class="text-sm font-semibold text-green-100">Sudah Dibayar</p>
                <p class="text-3xl font-bold">Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <p class="text-sm font-semibold text-red-100">Sisa Utang</p>
                <p class="text-3xl font-bold">Rp {{ number_format($sisaUtang ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                <p class="text-sm font-semibold text-indigo-100">Warga Berutang</p>
                <p class="text-3xl font-bold">{{ $wargaBerutang ?? 0 }} Orang</p>
            </div>
        </div>

        <!-- Statistik Utang Warga -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-orange-100">Total Utang</p>
                        <p class="text-3xl font-bold text-white">Rp {{ number_format($totalUtang ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-orange-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-100">Sudah Dibayar</p>
                        <p class="text-3xl font-bold text-white">Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-red-100">Sisa Utang</p>
                        <p class="text-3xl font-bold text-white">Rp {{ number_format($sisaUtang ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-red-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-indigo-100">Warga Berutang</p>
                        <p class="text-3xl font-bold text-white">{{ $wargaBerutang ?? 0 }}</p>
                        <p class="text-xs text-indigo-200">Orang</p>
                    </div>
                    <div class="p-3 bg-indigo-400 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Bantuan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Bantuan per Jenis -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bantuan per Jenis</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">PKH</span>
                        </div>
                        <span class="text-xl font-bold text-blue-600">{{ $penerimaPKH }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">BPNT</span>
                        </div>
                        <span class="text-xl font-bold text-green-600">{{ $penerimaBPNT }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">BLT</span>
                        </div>
                        <span class="text-xl font-bold text-yellow-600">{{ $penerimaBLT }}</span>
                    </div>
                </div>
            </div>

            <!-- Demografi -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Demografi</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">Laki-laki</span>
                        </div>
                        <span class="text-xl font-bold text-blue-600">{{ $lakiLaki }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-pink-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">Perempuan</span>
                        </div>
                        <span class="text-xl font-bold text-pink-600">{{ $perempuan }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-500 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-700">Kepala Keluarga</span>
                        </div>
                        <span class="text-xl font-bold text-gray-600">{{ $kepalaKeluarga }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('residents.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Data Warga</p>
                        <p class="text-sm text-gray-600">Kelola data warga</p>
                    </div>
                </a>
                <a href="{{ route('houses.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Peta Rumah</p>
                        <p class="text-sm text-gray-600">Lihat peta interaktif</p>
                    </div>
                </a>
                <a href="{{ route('residents.export') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Export Data</p>
                        <p class="text-sm text-gray-600">Download laporan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection