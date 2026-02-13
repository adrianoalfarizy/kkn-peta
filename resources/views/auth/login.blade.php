@php($title = 'Login Admin')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gradient-to-b from-orange-50 to-neutral-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold text-orange-600">KKN Peta Gunungsari</h1>
            <p class="text-sm text-neutral-600 mt-1">Login Admin Kelurahan</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6">
            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-4 rounded-md border border-blue-300 bg-blue-50 p-3 text-sm text-blue-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="rounded-md border border-neutral-300 px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium">Password</label>
                    <input type="password" name="password" required class="rounded-md border border-neutral-300 px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-neutral-300 text-orange-600 focus:ring-orange-500">
                    <label for="remember" class="ml-2 text-sm text-neutral-700">Ingat saya</label>
                </div>

                <button type="submit" class="w-full h-10 rounded-md bg-orange-600 text-sm font-medium text-white hover:bg-orange-700">
                    Login
                </button>
            </form>
        </div>

        <div class="mt-4 text-center text-xs text-neutral-600">
            <p>&copy; {{ date('Y') }} KKN Peta Gunungsari</p>
            <p class="mt-1 text-neutral-500">Hubungi admin untuk informasi akses</p>
        </div>
    </div>
</body>
</html>
