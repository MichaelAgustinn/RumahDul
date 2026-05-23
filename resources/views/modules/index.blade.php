@extends('layouts.app')

@section('content')
    <!-- Hero Section / Form Filter & Search -->
    <div class="mb-14 relative z-10">
        <div class="absolute -inset-1 bg-gradient-to-r from-gray-200 to-red-50 rounded-[2rem] blur-2xl opacity-40 -z-10">
        </div>

        <div
            class="bg-white/90 backdrop-blur-2xl p-8 sm:p-10 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden transition-all hover:shadow-md">
            <div class="max-w-4xl relative z-10">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight leading-tight">
                    Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#6a0000] to-red-600">Modul
                        Pembelajaran</span>
                </h1>
                <p class="text-gray-500 mb-8 text-base sm:text-lg font-medium max-w-2xl">Temukan referensi praktikum dan
                    modul ajar keperawatan dengan cepat, mudah, dan terstruktur.</p>

                <form action="{{ route('modules.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">

                    <div class="relative flex-grow group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-[#6a0000]">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#6a0000] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari judul modul..."
                            value="{{ request('search') }}"
                            class="w-full pl-11 pr-4 py-4 rounded-xl border-0 ring-1 ring-gray-200 bg-white hover:ring-gray-300 focus:bg-white focus:ring-2 focus:ring-[#6a0000] transition-all shadow-sm outline-none text-gray-800 font-medium placeholder-gray-400">
                    </div>

                    <div class="sm:w-1/3 relative group">
                        <select name="jenis"
                            class="w-full px-4 py-4 rounded-xl border-0 ring-1 ring-gray-200 bg-white hover:ring-gray-300 focus:bg-white focus:ring-2 focus:ring-[#6a0000] transition-all shadow-sm outline-none text-gray-700 font-medium cursor-pointer appearance-none">
                            <option value="">Semua Kategori</option>
                            <option value="modul praktikum" {{ request('jenis') == 'modul praktikum' ? 'selected' : '' }}>
                                Modul Praktikum</option>
                            <option value="modul ajar" {{ request('jenis') == 'modul ajar' ? 'selected' : '' }}>Modul Ajar
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-[#6a0000]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="sm:w-auto">
                        <button type="submit"
                            class="w-full h-full bg-[#6a0000] text-white font-bold py-4 px-8 rounded-xl shadow-md hover:bg-[#5a0000] hover:-translate-y-0.5 hover:shadow-lg active:scale-95 transition-all duration-200 flex items-center justify-center">
                            Cari Modul
                        </button>
                    </div>
                </form>
            </div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-gray-100 rounded-full blur-3xl opacity-50 z-0"></div>
        </div>
    </div>

    <!-- Daftar Modul Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 opacity-0 animate-fade-in delay-100">
        @forelse($modules as $modul)
            <div
                class="group bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100 transform transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col relative">

                <!-- Area Cover Modul JS Render -->
                <div
                    class="relative w-full h-48 sm:h-56 bg-gray-100 overflow-hidden border-b border-gray-100 flex items-center justify-center">

                    <!-- Canvas tempat PDF digambar -->
                    <canvas
                        class="pdf-canvas w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 ease-in-out hidden"
                        data-pdf-url="{{ asset($modul->file_path) }}"></canvas>

                    <!-- Loading Indicator -->
                    <div
                        class="pdf-loading absolute inset-0 flex flex-col items-center justify-center bg-gray-50 text-gray-400">
                        <svg class="animate-spin w-8 h-8 mb-2 text-red-700" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Memuat Cover...</span>
                    </div>

                    <!-- Overlay Gradien -->
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-transparent pointer-events-none">
                    </div>

                    <!-- Badge Kategori -->
                    <div class="absolute top-4 left-4 z-10">
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-widest shadow-lg backdrop-blur-md {{ $modul->jenis == 'modul praktikum' ? 'bg-amber-400/95 text-amber-950' : 'bg-blue-500/95 text-white' }}">
                            {{ $modul->jenis }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-grow">
                    <div class="flex justify-end items-start mb-3">
                        <span
                            class="text-[11px] font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-md border border-gray-100 flex items-center">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $modul->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <h3
                        class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 leading-snug group-hover:text-[#6a0000] transition-colors duration-300">
                        {{ $modul->judul }}
                    </h3>

                    <div class="space-y-2 mb-2">
                        <div class="flex items-center text-sm">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mr-3 text-gray-400 group-hover:bg-red-50 group-hover:border-red-100 group-hover:text-[#6a0000] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Mata Kuliah
                                </p>
                                <p class="font-bold text-gray-700">{{ $modul->mata_kuliah }}</p>
                            </div>
                        </div>

                        <div class="flex items-center text-sm">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mr-3 text-gray-400 group-hover:bg-red-50 group-hover:border-red-100 group-hover:text-[#6a0000] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Dosen</p>
                                <p class="font-bold text-gray-700">{{ $modul->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions: Tombol Lihat dan Unduh -->
                <div
                    class="px-6 py-4 border-t border-gray-50 bg-gray-50/50 group-hover:bg-red-50/20 transition-colors flex gap-3">

                    <!-- Tombol Lihat -->
                    <a href="{{ route('modules.view', $modul->id) }}" target="_blank"
                        class="flex-1 flex justify-center items-center text-xs sm:text-sm font-bold text-[#6a0000] hover:text-white hover:bg-[#6a0000] bg-white px-3 py-2.5 rounded-xl transition-all duration-300 active:scale-95 border border-red-200 hover:border-transparent shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Lihat
                    </a>

                    <!-- Tombol Unduh -->
                    <a href="{{ route('modules.download', $modul->id) }}"
                        class="flex-1 flex justify-center items-center text-xs sm:text-sm font-bold text-[#6a0000] hover:text-white hover:bg-[#6a0000] bg-white px-3 py-2.5 rounded-xl transition-all duration-300 active:scale-95 border border-red-200 hover:border-transparent shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh
                    </a>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-16 bg-white/80 backdrop-blur-sm rounded-2xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-center transition-all hover:border-gray-300 shadow-sm">
                <div
                    class="bg-gray-50 border border-gray-100 p-5 rounded-full mb-4 transform transition-transform hover:scale-110 duration-300">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pencarian Tidak Ditemukan</h3>
                <p class="text-sm text-gray-500 max-w-sm font-medium">Belum ada modul yang sesuai dengan filter pencarian
                    Anda, atau modul belum diunggah.</p>
                @if (request('search') || request('jenis'))
                    <a href="{{ route('modules.index') }}"
                        class="mt-5 px-5 py-2 bg-gray-100 text-gray-700 border border-gray-200 font-bold rounded-lg hover:bg-gray-200 transition-all duration-300 active:scale-95">Reset
                        Filter</a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center opacity-0 animate-fade-in delay-200">
        {{ $modules->links() }}
    </div>

    <!-- Script Render Cover PDF dengan Javascript (Client-Side) -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvases = document.querySelectorAll('.pdf-canvas');

            canvases.forEach(canvas => {
                const url = canvas.getAttribute('data-pdf-url');
                const loadingDiv = canvas.nextElementSibling;

                pdfjsLib.getDocument(url).promise.then(pdf => {
                    return pdf.getPage(1);
                }).then(page => {
                    const viewport = page.getViewport({
                        scale: 1.5
                    });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    const renderContext = {
                        canvasContext: canvas.getContext('2d'),
                        viewport: viewport
                    };

                    page.render(renderContext).promise.then(() => {
                        loadingDiv.style.display = 'none';
                        canvas.classList.remove('hidden');
                    });
                }).catch(err => {
                    console.error('Gagal meload cover PDF:', err);
                    loadingDiv.innerHTML = `
                        <svg class="w-10 h-10 mb-2 text-red-200/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-[10px] font-bold text-red-300/80 uppercase tracking-widest">COVER PDF</span>
                    `;
                });
            });
        });
    </script>
@endsection
