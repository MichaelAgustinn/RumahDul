<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Rumahdul</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen px-6">

    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl border-t-4 border-[#800000] p-10 text-center">
        <!-- Ikon Error Peringatan -->
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
            <svg class="h-10 w-10 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @yield('icon')
            </svg>
        </div>

        <!-- Kode Error (Misal: 404) -->
        <h1 class="text-6xl font-extrabold text-gray-900 mb-2 tracking-tight">
            @yield('code')
        </h1>

        <!-- Judul Error -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            @yield('message')
        </h2>

        <!-- Deskripsi Tambahan -->
        <p class="text-gray-500 mb-8 text-sm leading-relaxed">
            @yield('description', 'Maaf, sepertinya ada masalah atau halaman yang Anda tuju tidak tersedia.')
        </p>

        <!-- Tombol Kembali -->
        <a href="{{ url('/') }}"
            class="inline-flex items-center justify-center bg-[#800000] hover:bg-[#5a0000] text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

</body>

</html>
