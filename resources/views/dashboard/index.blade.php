@extends('welcome')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-primary">
                <i class="text-3xl">🗺️</i>
            </div>
            <div class="stat-title">Total Provinsi</div>
            <div class="stat-value text-primary">34</div>
            <div class="stat-desc">↗︎ 2 (6%)</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-secondary">
                <i class="text-3xl">📍</i>
            </div>
            <div class="stat-title">Total Kabupaten</div>
            <div class="stat-value text-secondary">514</div>
            <div class="stat-desc">↗︎ 15 (3%)</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-accent">
                <i class="text-3xl">👥</i>
            </div>
            <div class="stat-title">Total Penduduk</div>
            <div class="stat-value text-accent">273.8M</div>
            <div class="stat-desc">↗︎ 1.2M (0.4%)</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-success">
                <i class="text-3xl">📊</i>
            </div>
            <div class="stat-title">Data Terbaru</div>
            <div class="stat-value text-success">2024</div>
            <div class="stat-desc">↗︎ Update terbaru</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Data -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">📋 Data Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Jumlah Penduduk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DKI Jakarta</td>
                                <td>Jakarta Pusat</td>
                                <td>914,182</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                            </tr>
                            <tr>
                                <td>Jawa Barat</td>
                                <td>Bandung</td>
                                <td>2,444,160</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                            </tr>
                            <tr>
                                <td>Jawa Timur</td>
                                <td>Surabaya</td>
                                <td>2,874,699</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">⚡ Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('provinsi.index') }}" class="btn btn-primary">
                        <i class="mr-2">🗺️</i>
                        Kelola Provinsi
                    </a>
                    <a href="{{ route('kabupaten.index') }}" class="btn btn-secondary">
                        <i class="mr-2">📍</i>
                        Kelola Kabupaten
                    </a>
                    <button class="btn btn-accent">
                        <i class="mr-2">📊</i>
                        Lihat Laporan
                    </button>
                    <button class="btn btn-info">
                        <i class="mr-2">⚙️</i>
                        Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
