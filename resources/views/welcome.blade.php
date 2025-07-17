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
        <div class="drawer-content flex flex-col">
            <!-- Top Navigation -->
            <div class="navbar bg-base-100 shadow-lg">
                <div class="flex-none lg:hidden">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <i class="w-6 h-6">☰</i>
                    </label>
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-semibold">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div
                                class="w-full h-full rounded-full bg-primary text-primary-content border-4 border-gray-300">
                            </div>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a>Profile</a></li>
                            <li><a>Settings</a></li>
                            <li><a>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-6 bg-base-200">
                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="w-64 min-h-full bg-base-100 shadow-lg">
                <div class="p-4">
                    <h2 class="text-2xl font-bold text-primary">Data Penduduk</h2>
                </div>
                <ul class="menu p-4 w-full">
                    <li>
                        <a href="{{ route('dashboard') }}" class="@if (request()->routeIs('dashboard')) active @endif">
                            <i class="w-5 h-5">🏠</i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('provinsi.index') }}" class="@if (request()->routeIs('provinsi.*')) active @endif">
                            <i class="w-5 h-5">🗺️</i>
                            Provinsi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kabupaten.index') }}"
                            class="@if (request()->routeIs('kabupaten.*')) active @endif">
                            <i class="w-5 h-5">📍</i>
                            Kabupaten
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
    </div>
</body>

</html>
