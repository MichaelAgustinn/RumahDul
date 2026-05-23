@extends('layouts.dashboard')

@section('header_title', 'Manajemen Akun Dosen')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative">

        <!-- Form Tambah Dosen (Kiri) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800000] p-6 sticky top-6">
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
                        <p class="text-xs text-gray-500 mt-1">*NIDN otomatis akan menjadi username & password default.</p>
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

                <!-- Header & Pencarian -->
                <div
                    class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Sistem</h3>

                    <!-- Live Search Input -->
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="liveSearch" placeholder="Cari nama atau NIDN..."
                            class="w-full pl-9 pr-4 py-2 rounded-md border border-gray-300 focus:border-[#800000] focus:ring-1 focus:ring-[#800000] text-sm outline-none transition-all bg-white shadow-sm">
                    </div>
                </div>

                <div id="table-container" class="transition-opacity duration-300">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Info Pengguna</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">NIDN: {{ $user->nidn ?? '-' }}</div>
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

                                                    <!-- Tombol Edit Modal (Email dihapus dari argumen) -->
                                                    <button type="button"
                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->nidn }}', '{{ addslashes($user->name) }}')"
                                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                                        Edit
                                                    </button>
                                                    <span class="text-gray-300">|</span>

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
                                                            class="text-yellow-600 hover:text-yellow-800 font-semibold">Reset
                                                            Pass</button>
                                                    </form>
                                                    <span class="text-gray-300">|</span>

                                                    <!-- Hapus -->
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST"
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
    </div>

    <!-- MODAL EDIT DOSEN -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center transition-opacity">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-transform scale-95"
            id="modalContent">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-lg font-bold text-gray-800">Edit Data Pengguna</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" action="" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                    <input type="text" name="nidn" id="edit_nidn" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_name" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#800000] focus:ring-[#800000] px-4 py-2 border">
                </div>

                <div class="pt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded shadow hover:bg-gray-300 transition">Batal</button>
                    <button type="submit"
                        class="bg-[#800000] text-white px-4 py-2 rounded shadow hover:bg-[#5a0000] transition">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT AJAX & MODAL -->
    <script>
        // FUNGSI MODAL EDIT (Email dihapus)
        function openEditModal(id, nidn, name) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            form.action = "{{ url('admin/users') }}/" + id;

            document.getElementById('edit_nidn').value = nidn;
            document.getElementById('edit_name').value = name;

            modal.classList.remove('hidden');
            setTimeout(() => document.getElementById('modalContent').classList.remove('scale-95'), 10);
        }

        function closeEditModal() {
            document.getElementById('modalContent').classList.add('scale-95');
            setTimeout(() => document.getElementById('editModal').classList.add('hidden'), 200);
        }

        // FUNGSI LIVE SEARCH
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('liveSearch');
            const tableContainer = document.getElementById('table-container');
            let debounceTimer;

            const fetchTableData = (url) => {
                tableContainer.style.opacity = '0.5';
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        tableContainer.innerHTML = doc.getElementById('table-container').innerHTML;
                        tableContainer.style.opacity = '1';
                    }).catch(error => {
                        tableContainer.style.opacity = '1';
                    });
            };

            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = searchInput.value;
                    const url = new URL(window.location.href);

                    if (query) url.searchParams.set('search', query);
                    else url.searchParams.delete('search');
                    url.searchParams.delete('page');

                    window.history.pushState({}, '', url);
                    fetchTableData(url);
                }, 500);
            });

            tableContainer.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && !link.closest('form') && link.href.includes('page=')) {
                    e.preventDefault();
                    window.history.pushState({}, '', link.href);
                    fetchTableData(link.href);
                }
            });
        });
    </script>
@endsection
