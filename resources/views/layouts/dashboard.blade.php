<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rumahdul</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#800000] text-white flex flex-col h-full shadow-lg">
        <div class="h-16 flex items-center px-6 border-b border-[#5a0000]">
            <span class="text-xl font-bold tracking-wider">Rumahdul Panel</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="px-2 text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded-md hover:bg-[#5a0000] transition {{ request()->routeIs('dashboard') ? 'bg-[#5a0000]' : '' }}">
                Kelola Modul
            </a>

            <!-- Menu Khusus Admin -->
            <div class="mt-6">
                <p class="px-2 text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 mt-4">Administrator
                </p>
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
    <div class="flex-1 flex flex-col h-full">
        <!-- Top Header -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Dashboard')
            </h2>
            <div class="flex items-center">
                <span class="text-gray-600 font-medium mr-2">{{ Auth::user()->name }}</span>
                <span class="bg-red-100 text-[#800000] text-xs font-bold px-2 py-1 rounded-full uppercase">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </header>

        <!-- Content Body -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>

</html>
