@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Tambah User</h1>

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-3 rounded">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded border-gray-300" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded border-gray-300" />
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 block w-full rounded border-gray-300" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="mt-1 block w-full rounded border-gray-300" />
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" required class="mt-1 block w-full rounded border-gray-300">
                <option value="">-- Pilih Role --</option>
                <option value="super_admin" {{ old('role')=='super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin_desa" {{ old('role')=='admin_desa' ? 'selected' : '' }}>Admin Desa</option>
                <option value="operator" {{ old('role')=='operator' ? 'selected' : '' }}>Operator</option>
                <option value="rt_rw" {{ old('role')=='rt_rw' ? 'selected' : '' }}>RT/RW</option>
                <option value="viewer" {{ old('role')=='viewer' ? 'selected' : '' }}>Viewer</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded border-gray-300" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="address" class="mt-1 block w-full rounded border-gray-300">{{ old('address') }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
