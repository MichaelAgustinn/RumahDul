@extends('layouts.dashboard')

@section('header_title', 'Pengaturan Konten Website')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800000] p-8">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">Ubah Informasi Identitas Kampus</h3>
                <p class="text-sm text-gray-500 mt-1">Data ini akan ditampilkan pada halaman pencarian Guest (Judul Situs &
                    Footer).</p>
            </div>

            <form action="{{ route('admin.content.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul Situs -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Website (Header & Tab Browser)</label>
                    <input type="text" name="site_title" value="{{ old('site_title', $content->site_title) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                </div>

                <hr class="border-gray-200">
                <h4 class="text-md font-semibold text-gray-700 mt-4">Informasi Footer</h4>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Fakultas</label>
                    <textarea name="footer_address" rows="3" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">{{ old('footer_address', $content->footer_address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon / Kontak</label>
                        <input type="text" name="footer_phone" value="{{ old('footer_phone', $content->footer_phone) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Resmi</label>
                        <input type="email" name="footer_email" value="{{ old('footer_email', $content->footer_email) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="submit"
                        class="bg-[#800000] hover:bg-[#5a0000] text-white font-bold py-2 px-8 rounded shadow transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
