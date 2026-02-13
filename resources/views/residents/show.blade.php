@php($title = 'Detail Warga')
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-700 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Detail Data Warga</h1>
                <p class="text-blue-100 text-sm mt-1">{{ $resident->nama }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Informasi Dasar -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">NIK:</span>
                                <span class="font-medium">{{ $resident->nik }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">{{ $resident->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Kelamin:</span>
                                <span class="font-medium">{{ $resident->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tempat, Tanggal Lahir:</span>
                                <span class="font-medium">{{ $resident->tempat_lahir }}, {{ $resident->tanggal_lahir->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Umur:</span>
                                <span class="font-medium">{{ $resident->umur }} tahun</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Agama:</span>
                                <span class="font-medium">{{ $resident->agama }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Keluarga</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Keluarga:</span>
                                <span class="font-medium">{{ ucfirst($resident->status_keluarga) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Kawin:</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $resident->status_kawin)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pendidikan:</span>
                                <span class="font-medium">{{ $resident->pendidikan ?: 'Tidak ada data' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pekerjaan:</span>
                                <span class="font-medium">{{ $resident->pekerjaan ?: 'Tidak bekerja' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Ekonomi:</span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $resident->status_ekonomi === 'miskin' ? 'bg-red-100 text-red-800' : 
                                       ($resident->status_ekonomi === 'rentan_miskin' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $resident->status_ekonomi)) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">No HP:</span>
                                <span class="font-medium">{{ $resident->no_hp ?: 'Tidak ada' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Tempat Tinggal</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 font-medium">{{ $resident->house->alamat }}</p>
                        @if($resident->house->no_kk)
                            <p class="text-sm text-gray-600 mt-1">No KK: {{ $resident->house->no_kk }}</p>
                        @endif
                    </div>
                </div>

                <!-- Bantuan Sosial -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bantuan Sosial</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold {{ $resident->penerima_pkh ? 'text-blue-600' : 'text-gray-400' }}">
                                {{ $resident->penerima_pkh ? '✓' : '✗' }}
                            </div>
                            <div class="text-sm font-medium text-gray-700">PKH</div>
                            <div class="text-xs text-gray-500">Program Keluarga Harapan</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold {{ $resident->penerima_bpnt ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $resident->penerima_bpnt ? '✓' : '✗' }}
                            </div>
                            <div class="text-sm font-medium text-gray-700">BPNT</div>
                            <div class="text-xs text-gray-500">Bantuan Pangan Non Tunai</div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold {{ $resident->penerima_blt ? 'text-purple-600' : 'text-gray-400' }}">
                                {{ $resident->penerima_blt ? '✓' : '✗' }}
                            </div>
                            <div class="text-sm font-medium text-gray-700">BLT</div>
                            <div class="text-xs text-gray-500">Bantuan Langsung Tunai</div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                @if($resident->keterangan)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Keterangan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $resident->keterangan }}</p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                    @auth
                        <a href="{{ route('residents.edit', $resident) }}" class="flex-1 bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                            Edit Data
                        </a>
                    @endauth
                    <a href="{{ route('residents.index') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-center">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection