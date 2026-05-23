<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $module->judul }} - Rumahdul</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-900 h-screen flex flex-col">

    <!-- Topbar Khusus Viewer -->
    <div
        class="h-16 bg-[#2a0000] border-b border-[#4a0000] flex justify-between items-center px-6 shadow-lg z-10 shrink-0">

        <!-- Info Judul -->
        <div class="flex items-center text-white overflow-hidden">
            <a href="{{ route('modules.index') }}"
                class="mr-4 p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors group" title="Kembali">
                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="truncate">
                <h1 class="text-sm sm:text-base font-bold truncate">{{ $module->judul }}</h1>
                <p class="text-xs text-gray-400 truncate">{{ $module->mata_kuliah }} • Oleh: {{ $module->user->name }}
                </p>
            </div>
        </div>

        <!-- Tombol Unduh (Mencatat Statistik) -->
        <div class="ml-4 shrink-0">
            <a href="{{ route('modules.download', $module->id) }}"
                class="flex items-center text-sm font-bold text-white bg-red-600 hover:bg-red-500 px-4 py-2 rounded-lg transition-colors shadow-md border border-red-500 hover:border-red-400">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span class="hidden sm:inline">Unduh PDF</span>
                <span class="sm:hidden">Unduh</span>
            </a>
        </div>
    </div>

    <!-- Area PDF Menggunakan Iframe -->
    <div class="flex-grow relative w-full h-full bg-gray-800">
        <!-- Trik: Menambahkan #toolbar=0 di akhir URL akan memaksa browser menyembunyikan tombol download bawaannya -->
        <iframe src="{{ asset($module->file_path) }}#toolbar=0&navpanes=0&scrollbar=1"
            class="absolute inset-0 w-full h-full border-none" title="PDF Viewer">
        </iframe>
    </div>

</body>

</html>
