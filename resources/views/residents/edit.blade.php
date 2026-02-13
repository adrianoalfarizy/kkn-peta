@php($title = 'Edit Data Warga')
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Data Warga</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('residents.update', $resident) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rumah</label>
                        <select name="house_id" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            @foreach($houses as $house)
                                <option value="{{ $house->id }}" {{ old('house_id', $resident->house_id) == $house->id ? 'selected' : '' }}>
                                    {{ $house->alamat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $resident->nik) }}" required maxlength="16" class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $resident->nama) }}" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="L" {{ old('jenis_kelamin', $resident->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $resident->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $resident->tanggal_lahir->format('Y-m-d')) }}" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $resident->tempat_lahir) }}" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Keluarga</label>
                        <select name="status_keluarga" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="kepala" {{ old('status_keluarga', $resident->status_keluarga) == 'kepala' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="istri" {{ old('status_keluarga', $resident->status_keluarga) == 'istri' ? 'selected' : '' }}>Istri</option>
                            <option value="anak" {{ old('status_keluarga', $resident->status_keluarga) == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="orang_tua" {{ old('status_keluarga', $resident->status_keluarga) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="lainnya" {{ old('status_keluarga', $resident->status_keluarga) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Kawin</label>
                        <select name="status_kawin" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="belum_kawin" {{ old('status_kawin', $resident->status_kawin) == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="kawin" {{ old('status_kawin', $resident->status_kawin) == 'kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="cerai_hidup" {{ old('status_kawin', $resident->status_kawin) == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="cerai_mati" {{ old('status_kawin', $resident->status_kawin) == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                        <input type="text" name="agama" value="{{ old('agama', $resident->agama) }}" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan</label>
                        <input type="text" name="pendidikan" value="{{ old('pendidikan', $resident->pendidikan) }}" class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $resident->pekerjaan) }}" class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Ekonomi</label>
                        <select name="status_ekonomi" required class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="miskin" {{ old('status_ekonomi', $resident->status_ekonomi) == 'miskin' ? 'selected' : '' }}>Miskin</option>
                            <option value="tidak_miskin" {{ old('status_ekonomi', $resident->status_ekonomi) == 'tidak_miskin' ? 'selected' : '' }}>Tidak Miskin</option>
                            <option value="rentan_miskin" {{ old('status_ekonomi', $resident->status_ekonomi) == 'rentan_miskin' ? 'selected' : '' }}>Rentan Miskin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $resident->no_hp) }}" class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Program Bantuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="penerima_pkh" value="1" {{ old('penerima_pkh', $resident->penerima_pkh) ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">Penerima PKH</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="penerima_bpnt" value="1" {{ old('penerima_bpnt', $resident->penerima_bpnt) ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">Penerima BPNT</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="penerima_blt" value="1" {{ old('penerima_blt', $resident->penerima_blt) ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">Penerima BLT</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full rounded-md border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('keterangan', $resident->keterangan) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2.5 rounded-md bg-green-700 text-white font-medium hover:bg-green-800 transition">
                        Update Data
                    </button>
                    <a href="{{ route('residents.index') }}" class="px-6 py-2.5 rounded-md border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection