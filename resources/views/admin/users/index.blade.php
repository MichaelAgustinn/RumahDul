@extends('layouts.dashboard')

@section('header_title', 'Manajemen Akun Dosen')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Form Tambah Dosen (Kiri) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800000] p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Dosen Baru</h3>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                        <input type="text" name="nidn" required placeholder="Contoh: 0912345678"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                        <p class="text-xs text-gray-500 mt-1">*NIDN otomatis akan menjadi password default.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-[#800000] hover:bg-[#5a0000] text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Dosen (Kanan) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Sistem</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Info Pengguna</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">NIDN: {{ $user->nidn ?? '-' }} |
                                            {{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($user->id !== Auth::id())
                                            <div class="flex items-center justify-end space-x-3">

                                                <!-- Ubah Role -->
                                                <form action="{{ route('admin.users.update-role', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Ubah hak akses pengguna ini?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="role"
                                                        value="{{ $user->role === 'admin' ? 'dosen' : 'admin' }}">
                                                    <button type="submit"
                                                        class="text-[#800000] hover:text-[#5a0000] font-semibold">
                                                        Jadikan {{ $user->role === 'admin' ? 'Dosen' : 'Admin' }}
                                                    </button>
                                                </form>

                                                <span class="text-gray-300">|</span>

                                                <!-- Reset Password -->
                                                <form action="{{ route('admin.users.reset-password', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin reset password akun ini ke NIDN?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-yellow-600 hover:text-yellow-800 font-semibold">
                                                        Reset Pass
                                                    </button>
                                                </form>

                                                <span class="text-gray-300">|</span>

                                                <!-- Hapus -->
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus akun ini secara permanen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
