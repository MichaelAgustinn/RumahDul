@extends('layouts.dashboard')

@section('header_title', 'Edit Data Modul')

@section('content')

    <!-- CSS Choices.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .choices[data-type*=select-one] .choices__inner {
            border-radius: 0.75rem !important;
            border: 1px solid #d1d5db !important;
            background-color: #fef2f2 !important;
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

    <div class="max-w-5xl mx-auto space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative z-20">

            <div
                class="bg-gradient-to-r from-gray-700 to-gray-900 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Perbarui Informasi Modul
                </h2>
                <a href="{{ route('dashboard') }}"
                    class="text-xs font-bold text-gray-300 hover:text-white bg-white/10 px-3 py-1.5 rounded-lg transition-colors">
                    Kembali
                </a>
            </div>

            <div class="p-6 sm:p-8">
                <form action="{{ route('modules.update', $module->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT') <!-- Wajib untuk metode Edit di Laravel -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Judul Modul</label>
                            <input type="text" name="judul" value="{{ old('judul', $module->judul) }}" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Mata Kuliah</label>
                            <input type="text" name="mata_kuliah" value="{{ old('mata_kuliah', $module->mata_kuliah) }}"
                                required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Jenis Modul</label>
                            <select name="jenis" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 px-4 py-2.5 border transition-colors bg-gray-50 focus:bg-white cursor-pointer">
                                <option value="modul praktikum"
                                    {{ old('jenis', $module->jenis) == 'modul praktikum' ? 'selected' : '' }}>Modul
                                    Praktikum</option>
                                <option value="modul ajar"
                                    {{ old('jenis', $module->jenis) == 'modul ajar' ? 'selected' : '' }}>Modul Ajar
                                </option>
                            </select>
                        </div>

                        @if (Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Dosen Pemilik</label>
                                <select name="user_id" id="dosen_select_edit" required>
                                    <option value="{{ Auth::id() }}"
                                        {{ $module->user_id == Auth::id() ? 'selected' : '' }}>-- Saya Sendiri (Admin) --
                                    </option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id }}"
                                            {{ $module->user_id == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->name }} - {{ $dosen->nidn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="{{ Auth::user()->role === 'admin' ? '' : 'md:col-span-1' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">File PDF <span
                                    class="text-xs font-normal text-gray-400">(Opsional) *Biarkan kosong jika tidak ingin
                                    mengganti file PDF.</span></label>
                            <input type="file" name="file_pdf" accept="application/pdf"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 border border-gray-300 rounded-xl bg-gray-50 cursor-pointer transition-colors">
                            {{-- <p class="text-xs text-gray-400 mt-1.5"></p> --}}
                        </div>
                    </div>

                    <div class="pt-6 mt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit"
                            class="bg-gray-900 hover:bg-black text-white font-bold py-2.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 active:scale-95 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dosenSelect = document.getElementById('dosen_select_edit');
            if (dosenSelect) {
                new Choices(dosenSelect, {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Ketik nama atau NIDN dosen...',
                    itemSelectText: '',
                    shouldSort: false,
                    noResultsText: 'Dosen tidak ditemukan'
                });
            }
        });
    </script>
@endsection
