@extends('layouts.dashboard')

@section('header_title', 'Pengaturan Keamanan')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800000] p-8">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">Ubah Password</h3>
                <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak untuk
                    menjaga keamanan.</p>
            </div>

            <!-- Pesan Sukses -->
            @if (session('status'))
                <div class="mb-6 p-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Password Lama -->
                <div>
                    <label for="current_password" class="block text-sm font-bold text-gray-700 mb-1">Password Lama</label>
                    <input type="password" name="current_password" id="current_password"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border"
                        required>
                    @error('current_password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="border-gray-200">
                <h4 class="text-md font-semibold text-gray-700 mt-4">Setel Password Baru</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border"
                            required>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi
                            Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border"
                            required>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="pt-6 flex justify-end">
                    <button type="submit"
                        class="bg-[#800000] hover:bg-[#5a0000] text-white font-bold py-2 px-8 rounded shadow transition">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
