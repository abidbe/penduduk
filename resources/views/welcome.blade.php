<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>

<body>
    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />

        <!-- Main Content -->
        <div class="drawer-content flex flex-col min-h-screen">
            <!-- Top Navigation -->
            <div class="navbar bg-base-100 shadow-lg sticky top-0 z-10">
                <div class="flex-none lg:hidden">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-2">
                    <h1 class="text-lg sm:text-xl font-semibold truncate">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div
                                class="w-full h-full rounded-full bg-primary text-primary-content border-4 border-gray-300">
                            </div>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a class="text-sm">Profile</a></li>
                            <li><a class="text-sm">Settings</a></li>
                            <li><a class="text-sm">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 bg-base-200">
                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-20">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="w-64 min-h-full bg-base-100 shadow-lg">
                <div class="w-full p-4 flex justify-center border-b">
                    <h2 class="text-xl sm:text-2xl font-bold text-primary text-center">Data Penduduk</h2>
                </div>
                <ul class="menu p-4 w-full text-base gap-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="@if (request()->routeIs('dashboard')) active @endif">
                            <span class="text-lg">🏠</span>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('provinsi.index') }}" class="@if (request()->routeIs('provinsi.index')) active @endif">
                            <span class="text-lg">📍</span>
                            Provinsi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kabupaten.index') }}"
                            class="@if (request()->routeIs('kabupaten.index')) active @endif">
                            <span class="text-lg">🏘️</span>
                            Kabupaten/Kota
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('penduduk.index') }}" class="@if (request()->routeIs('penduduk.index')) active @endif">
                            <span class="text-lg">👥</span>
                            Penduduk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('provinsi.laporan') }}"
                            class="@if (request()->routeIs('provinsi.laporan')) active @endif">
                            <span class="text-lg">📊</span>
                            Laporan Provinsi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kabupaten.laporan') }}"
                            class="@if (request()->routeIs('kabupaten.laporan')) active @endif">
                            <span class="text-lg">📊</span>
                            Laporan Kabupaten
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
    </div>

    <!-- Script untuk menutup drawer ketika item diklik di mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const drawerToggle = document.getElementById('drawer-toggle');
            const menuItems = document.querySelectorAll('.drawer-side .menu a');

            menuItems.forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 1024) { // lg breakpoint
                        drawerToggle.checked = false;
                    }
                });
            });
        });
    </script>
</body>

</html>
