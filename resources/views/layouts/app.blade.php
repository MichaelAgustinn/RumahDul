<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $webContent->site_title ?? 'Rumahdul' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Library PDF.js untuk Cover Modul -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .bg-animated {
            background: linear-gradient(-45deg, #f8fafc, #f1f5f9, #f8fafc, #f3f4f6);
            background-size: 400% 400%;
            animation: gradientBG 20s ease infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6a0000;
        }
    </style>
</head>

<body class="bg-animated flex flex-col min-h-screen text-gray-800 selection:bg-[#6a0000] selection:text-white">

    <!-- Navbar: Deep Crimson Glassmorphism -->
    <nav
        class="sticky top-0 z-50 bg-gradient-to-r from-[#6a0000]/95 via-[#500000]/95 to-[#6a0000]/95 backdrop-blur-xl border-b border-white/10 shadow-[0_4px_20px_rgba(0,0,0,0.1)] transition-all duration-300">
        <div
            class="absolute bottom-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-red-500/50 to-transparent opacity-40">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex justify-between h-20 items-center">

                <div class="flex items-center space-x-3 group cursor-pointer">
                    <div
                        class="bg-white/10 p-2.5 rounded-xl backdrop-blur-md border border-white/10 group-hover:bg-white group-hover:scale-110 transition-all duration-300 shadow-inner">
                        <svg class="w-6 h-6 text-white group-hover:text-[#6a0000] transition-colors duration-300"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span
                            class="font-black text-xl sm:text-2xl text-white tracking-tight leading-none">RUMAHDUL</span>
                        {{-- <span
                            class="text-[10px] sm:text-xs text-gray-300 uppercase tracking-[0.2em] mt-1 font-bold">Keperawatan</span> --}}
                    </div>
                </div>

                <div class="flex items-center space-x-5">
                    @auth
                        <span class="hidden md:inline-block text-sm font-medium text-gray-300">
                            Halo, <span class="text-white font-bold">{{ Auth::user()->name }}</span>
                        </span>
                        <a href="{{ route('dashboard') }}">
                            <button
                                class="bg-white text-[#6a0000] px-5 py-2.5 rounded-xl text-sm font-bold shadow-[0_4px_14px_0_rgba(255,255,255,0.1)] hover:shadow-[0_6px_20px_rgba(255,255,255,0.2)] hover:-translate-y-0.5 active:scale-95 transition-all duration-200">
                                Buka Dashboard
                            </button>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full animate-fade-in opacity-0">
        @yield('content')
    </main>

    <!-- Footer: Deep Crimson -->
    <footer
        class="relative bg-gradient-to-b from-[#5a0000] to-[#3a0000] text-gray-200 pt-16 pb-8 overflow-hidden mt-auto border-t border-[#6a0000]">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-[#800000]/20 blur-[120px] rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12 mb-12">

                <div class="md:col-span-5 space-y-6">
                    <div class="group inline-flex items-center space-x-3 cursor-pointer">
                        <div
                            class="bg-white/10 p-2.5 rounded-xl backdrop-blur-md border border-white/10 group-hover:bg-white group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7 text-white group-hover:text-[#5a0000] transition-colors"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-3xl text-white tracking-tight">RUMAHDUL.</span>
                            <span class="text-xs text-gray-400 uppercase tracking-[0.2em] font-bold">Fakultas
                                Kesehatan</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-300 max-w-sm font-medium">
                        Sistem digitalisasi modul pembelajaran keperawatan Universitas Sulawesi Barat. Memudahkan akses
                        referensi untuk mahasiswa dan dosen.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h3 class="font-bold text-white text-lg mb-6 flex items-center">
                        <span class="w-8 h-[2px] bg-red-500 mr-3"></span> Tautan Akses
                    </h3>
                    <ul class="space-y-4 font-medium">
                        <li>
                            <a href="{{ route('modules.index') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-300 w-max">
                                <span
                                    class="w-0 h-[2px] bg-white mr-0 group-hover:w-3 group-hover:mr-2 transition-all duration-300"></span>
                                Pencarian Modul
                            </a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="group flex items-center text-gray-300 hover:text-white transition-colors duration-300 w-max">
                                    <span
                                        class="w-0 h-[2px] bg-white mr-0 group-hover:w-3 group-hover:mr-2 transition-all duration-300"></span>
                                    Dashboard Pengguna
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                    class="group flex items-center text-gray-300 hover:text-white transition-colors duration-300 w-max">
                                    <span
                                        class="w-0 h-[2px] bg-white mr-0 group-hover:w-3 group-hover:mr-2 transition-all duration-300"></span>
                                    Login Dosen / Admin
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-4">
                    <h3 class="font-bold text-white text-lg mb-6 flex items-center">
                        <span class="w-8 h-[2px] bg-red-500 mr-3"></span> Hubungi Kami
                    </h3>

                    <a href="mailto:{{ $webContent->footer_email ?? 'admin@unsulbar.ac.id' }}"
                        class="group flex items-center p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all duration-300 transform hover:-translate-y-1 shadow-sm">
                        <div
                            class="bg-black/20 p-3 rounded-lg group-hover:bg-red-500/20 text-gray-300 group-hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-gray-300 transition-colors">
                                Kirim Email</p>
                            <p class="text-sm font-bold text-white transition-colors">
                                {{ $webContent->footer_email ?? 'admin@unsulbar.ac.id' }}</p>
                        </div>
                    </a>

                    <div
                        class="group flex items-center p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all duration-300 transform hover:-translate-y-1 shadow-sm cursor-pointer">
                        <div
                            class="bg-black/20 p-3 rounded-lg group-hover:bg-red-500/20 text-gray-300 group-hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wider group-hover:text-gray-300 transition-colors">
                                Telepon</p>
                            <p class="text-sm font-bold text-white transition-colors">
                                {{ $webContent->footer_phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <a href="https://maps.google.com/?q={{ urlencode($webContent->footer_address ?? 'Universitas Sulawesi Barat') }}"
                    target="_blank"
                    class="flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors group">
                    <svg class="w-4 h-4 mr-2 text-red-500 group-hover:animate-bounce" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $webContent->footer_address ?? 'Jl. Prof. Dr. Baharuddin Lopa, Majene' }}
                </a>

                <div class="flex items-center space-x-6">
                    <p class="text-xs text-gray-500 font-bold tracking-wide">
                        &copy; {{ date('Y') }} ISC UNSULBAR. All rights reserved.
                    </p>

                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="group bg-white/5 hover:bg-white/10 p-2 rounded-lg border border-white/10 transition-all duration-300 focus:outline-none shadow-sm">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white group-hover:-translate-y-1 transition-all"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
