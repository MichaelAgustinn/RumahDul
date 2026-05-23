<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rumahdul</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden relative">

    <!-- Overlay untuk Mobile (Gelap saat menu terbuka) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <!-- Tambahan class: absolute, z-50, transform, -translate-x-full, lg:relative, lg:translate-x-0 -->
    <aside id="sidebar"
        class="absolute lg:relative z-50 w-64 bg-[#800000] text-white flex flex-col h-full shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

        <div class="h-16 flex items-center justify-between px-6 border-b border-[#5a0000]">
            <span class="text-xl font-bold tracking-wider">Rumahdul Panel</span>
            <!-- Tombol Close (X) hanya untuk Mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-300 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="px-2 text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Menu Utama</p>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.statistic.dashboard') }}"
                    class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('admin.statistic.dashboard') ? 'bg-[#5a0000]' : '' }}">
                    Dashboard
                </a>
            @endif

            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('dashboard') ? 'bg-[#5a0000]' : '' }}">
                Kelola Modul
            </a>

            <!-- Menu Khusus Admin -->
            <div class="mt-6">
                <p class="px-2 text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 mt-4">Administrator</p>
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users') }}"
                        class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('admin.users') ? 'bg-[#5a0000]' : '' }}">
                        Manajemen Dosen
                    </a>
                    <a href="{{ route('admin.content.edit') }}"
                        class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('admin.content.edit') ? 'bg-[#5a0000]' : '' }}">
                        Pengaturan Web
                    </a>
                @endif
                <a href="{{ route('admin.password.edit') }}"
                    class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('admin.password.edit') ? 'bg-[#5a0000]' : '' }}">
                    Ganti Password
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-[#5a0000]">
            <a href="{{ route('modules.index') }}"
                class="block px-4 py-2 text-sm text-center text-gray-200 hover:text-white hover:bg-[#5a0000] rounded-md transition mb-2">
                &larr; Ke Halaman Depan
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-white text-[#800000] px-4 py-2 rounded-md font-bold hover:bg-gray-100 transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-full w-full overflow-hidden">

        <!-- Top Header -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-8 border-b z-30">
            <div class="flex items-center">
                <!-- Tombol Hamburger (Hanya tampil di Mobile/Tablet) -->
                <button onclick="toggleSidebar()"
                    class="lg:hidden mr-4 text-gray-600 hover:text-[#800000] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <h2 class="text-lg lg:text-xl font-semibold text-gray-800 truncate max-w-[150px] sm:max-w-xs">
                    @yield('header_title', 'Dashboard')
                </h2>
            </div>

            <div class="flex items-center">
                <!-- Nama disembunyikan sebagian jika layar terlalu kecil -->
                <span class="text-gray-600 font-medium mr-2 hidden sm:block">{{ Auth::user()->name }}</span>
                <span class="bg-red-100 text-[#800000] text-xs font-bold px-2 py-1 rounded-full uppercase">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </header>

        <!-- Content Body -->
        <!-- Ubah padding: p-4 untuk HP, lg:p-8 untuk Desktop -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8 w-full">
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div
                    class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-sm font-medium">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Script untuk Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Toggle posisi menu (geser masuk/keluar)
            sidebar.classList.toggle('-translate-x-full');

            // Toggle overlay gelap
            overlay.classList.toggle('hidden');
        }
    </script>

</body>

</html>
