@extends('layouts.dashboard') <!-- Sesuaikan dengan nama file layout utama kamu, misal: layouts.main -->

@section('content')
    <div class="max-w-2xl mx-auto p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 mb-6">
            Update Password
        </h2>

        <!-- Pesan Sukses -->
        @if (session('status'))
            <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <!-- Password Lama -->
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                <input type="password" name="current_password" id="current_password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('current_password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password
                    Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <!-- Tombol Simpan -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
@endsection
