@extends('layouts.dashboard')

@section('header_title', 'Dashboard Kelola Modul')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        /* Kustomisasi agar serasi dengan Tailwind Tema Maroon */
        .choices[data-type*=select-one] .choices__inner {
            border-radius: 0.75rem !important;
            /* rounded-xl */
            border: 1px solid #d1d5db !important;
            background-color: #fef2f2 !important;
            /* bg-red-50 */
            padding: 0.4rem 1rem !important;
            font-weight: 500 !important;
            color: #6a0000 !important;
            min-height: 46px;
            display: flex;
            align-items: center;
        }

        .choices.is-focused .choices__inner {
            border-color: #6a0000 !important;
            box-shadow: 0 0 0 2px rgba(106, 0, 0, 0.1) !important;
        }

        .choices__list--dropdown {
            border-radius: 0.75rem !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            margin-top: 5px;
        }

        .choices__input {
            background-color: #f3f4f6 !important;
            border-radius: 0.5rem !important;
            margin-bottom: 10px !important;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: #fef2f2 !important;
            color: #6a0000 !important;
        }
    </style>
    <div class="space-y-8">

        <!-- FORM UPLOAD SECTION -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative z-20">
            <div class="bg-gradient-to-r from-[#6a0000] to-[#800000] px-6 py-4 rounded-t-2xl">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Unggah Modul Baru
                </h2>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul Modul -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Judul Modul</label>
                            <input type="text" name="judul" required placeholder="Contoh: Konsep Dasar Keperawatan"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#6a0000] focus:ring-[#6a0000] px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white">
                        </div>

                        <!-- Mata Kuliah -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Mata Kuliah</label>
                            <input type="text" name="mata_kuliah" required
                                placeholder="Contoh: Keperawatan Medikal Bedah"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#6a0000] focus:ring-[#6a0000] px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                        <!-- Jenis Modul -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Jenis Modul</label>
                            <select name="jenis" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#6a0000] focus:ring-[#6a0000] px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white cursor-pointer">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="modul praktikum">Modul Praktikum</option>
                                <option value="modul ajar">Modul Ajar</option>
                            </select>
                        </div>

                        @if (Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Dosen Pemilik (Author)</label>
                                <select name="user_id" id="dosen_select" required>
                                    <option value="{{ Auth::id() }}">-- Saya Sendiri (Admin) --</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id }}"
                                            {{ old('user_id') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->name }} - {{ $dosen->nidn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Upload File PDF -->
                        <div class="{{ Auth::user()->role === 'admin' ? '' : 'md:col-span-1' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">File PDF (Maks. 15MB)</label>
                            <input type="file" name="file_pdf" accept="application/pdf" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-[#6a0000] hover:file:bg-red-100 border border-gray-300 rounded-xl bg-gray-50 cursor-pointer transition-colors">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                            class="bg-[#6a0000] hover:bg-[#500000] text-white font-bold py-2.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 active:scale-95 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Simpan Modul
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Tabel & Kolom Live Search -->
            <div
                class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-gray-50/50 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Modul</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        @if (Auth::user()->role === 'admin')
                            Menampilkan seluruh modul yang ada di sistem.
                        @else
                            Menampilkan seluruh modul yang telah Anda unggah.
                        @endif
                    </p>
                </div>

                <!-- Live Search Input -->
                <div class="w-full md:w-72 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="liveSearch" placeholder="Cari judul atau mata kuliah..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#6a0000] focus:ring-1 focus:ring-[#6a0000] text-sm outline-none transition-all bg-white shadow-sm placeholder-gray-400">
                </div>
            </div>

            <!-- Container Tabel (Untuk di-replace oleh JavaScript) -->
            <div id="table-container" class="transition-opacity duration-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                    Judul & Mata Kuliah</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                    Kategori</th>

                                @if (Auth::user()->role === 'admin')
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                        Pemilik (Dosen)</th>
                                @endif

                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($modules as $modul)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mt-1">
                                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-bold text-gray-900 line-clamp-1">
                                                    {{ $modul->judul }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">{{ $modul->mata_kuliah }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-md uppercase tracking-wider {{ $modul->jenis == 'modul praktikum' ? 'bg-amber-50 text-amber-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $modul->jenis }}
                                        </span>
                                    </td>

                                    @if (Auth::user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ $modul->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-400">{{ $modul->user->email }}</div>
                                        </td>
                                    @endif

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $modul->created_at->format('d M Y') }}
                                    </td>

                                    <!-- Aksi (Lihat, Edit & Hapus) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <!-- Tombol Lihat -->
                                            <a href="{{ Storage::url($modul->file_path) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors"
                                                title="Lihat PDF">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Tombol Edit Baru -->
                                            <a href="{{ route('admin.modules.edit', $modul->id) }}"
                                                class="text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 p-2 rounded-lg transition-colors"
                                                title="Edit Modul">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.modules.destroy', $modul) }}" method="POST"
                                                onsubmit="return confirm('Hapus modul ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                                    title="Hapus Modul">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}"
                                        class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <span class="block text-sm font-bold">Data modul tidak ditemukan.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                @if ($modules->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $modules->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('liveSearch');
            const tableContainer = document.getElementById('table-container');
            let debounceTimer;

            // Fungsi untuk Fetch Data Tabel
            const fetchTableData = (url) => {
                // Efek loading transparan
                tableContainer.style.opacity = '0.5';

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        // Parsing HTML yang dikembalikan server
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Ganti isi tabel lama dengan tabel baru hasil query
                        const newContent = doc.getElementById('table-container').innerHTML;
                        tableContainer.innerHTML = newContent;

                        // Kembalikan opacity
                        tableContainer.style.opacity = '1';
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        tableContainer.style.opacity = '1';
                    });
            };

            // Event Listener Ngetik di Search Box (Live Search)
            searchInput.addEventListener('input', function() {
                // Hapus timer sebelumnya jika masih ngetik (Debounce)
                clearTimeout(debounceTimer);

                // Eksekusi request 500ms setelah user berhenti ngetik
                debounceTimer = setTimeout(() => {
                    const query = searchInput.value;
                    const url = new URL(window.location.href);

                    if (query) {
                        url.searchParams.set('search', query);
                    } else {
                        url.searchParams.delete('search');
                    }

                    // Hapus parameter page agar kembali ke halaman 1 saat mulai mencari
                    url.searchParams.delete('page');

                    // Perbarui URL browser tanpa reload
                    window.history.pushState({}, '', url);

                    // Panggil data
                    fetchTableData(url);
                }, 500);
            });

            // Event Listener Klik Tombol Paginasi Tanpa Reload
            tableContainer.addEventListener('click', function(e) {
                const link = e.target.closest('a'); // Cari elemen <a> (link paginasi)

                // Jika yang diklik adalah tombol paginate dan bukan tombol Hapus/View PDF
                if (link && link.href && !link.closest('form') && !link.target && !link.href.includes(
                        '/edit')) {
                    e.preventDefault();
                    window.history.pushState({}, '', link.href);
                    fetchTableData(link.href);
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah elemen select dosen ada (hanya dirender jika login sebagai admin)
            const dosenSelect = document.getElementById('dosen_select');

            if (dosenSelect) {
                new Choices(dosenSelect, {
                    searchEnabled: true, // Aktifkan kolom pencarian
                    searchPlaceholderValue: 'Ketik nama atau NIDN dosen...', // Teks bayangan di kolom cari
                    itemSelectText: '', // Hilangkan teks default "Press to select"
                    shouldSort: false, // Pertahankan urutan abjad dari database
                    noResultsText: 'Dosen tidak ditemukan' // Pesan jika tidak ada hasil
                });
            }
        });
    </script>
@endsection
