<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rumahdul</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header Card -->
        <div class="bg-[#800000] text-white text-center py-6">
            <h1 class="text-3xl font-bold tracking-wider">Rumahdul</h1>
            {{-- <p class="text-sm mt-1 text-gray-200">Digitalisasi Modul Keperawatan</p> --}}
        </div>

        <div class="p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Silakan Login</h2>

            <!-- Pesan Error -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-sm text-red-700 font-medium">{{ $errors->first('nidn') }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="nidn" class="block text-sm font-bold text-gray-700 mb-1.5">NIDN</label>
                    <input type="text" name="nidn" id="nidn" value="{{ old('nidn') }}" required autofocus
                        placeholder="Masukkan NIDN Anda"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#6a0000] focus:ring-2 focus:ring-[#6a0000]/20 px-4 py-3 border transition-all bg-gray-50 focus:bg-white text-gray-800 font-medium">
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#6a0000] focus:ring-2 focus:ring-[#6a0000]/20 px-4 py-3 border transition-all bg-gray-50 focus:bg-white text-gray-800 font-medium">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#800000] hover:bg-[#5a0000] text-white font-bold py-2 px-4 rounded transition duration-150 shadow">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('modules.index') }}" class="text-sm text-[#800000] hover:underline">
                    &larr; Kembali ke Beranda Guest
                </a>
            </div>
        </div>
    </div>

</body>

</html>
