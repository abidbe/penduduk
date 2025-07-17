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
            <div class="stat-value text-primary">{{ $totalProvinsi }}</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-secondary">
                <i class="text-3xl">📍</i>
            </div>
            <div class="stat-title">Total Kabupaten</div>
            <div class="stat-value text-secondary">{{ $totalKabupaten }}</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-accent">
                <i class="text-3xl">👥</i>
            </div>
            <div class="stat-title">Total Penduduk</div>
            <div class="stat-value text-accent">{{ number_format($totalPenduduk) }}</div>
        </div>

        <div class="stat bg-base-100 shadow-lg rounded-lg">
            <div class="stat-figure text-success">
                <i class="text-3xl">📊</i>
            </div>
            <div class="stat-title">Rata-rata Umur</div>
            <div class="stat-value text-success">{{ number_format($rataRataUmur, 1) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Data -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">📋 Data Penduduk Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Kabupaten</th>
                                <th>Umur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendudukTerbaru as $penduduk)
                                <tr>
                                    <td>{{ $penduduk->nik }}</td>
                                    <td>{{ $penduduk->nama }}</td>
                                    <td>{{ $penduduk->kabupaten->nama_kabupaten }}</td>
                                    <td>{{ $penduduk->umur }} tahun</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">⚡ Quick Actions</h2>
                <div class="flex flex-col md:flex-row md:flex-wrap gap-2">
                    <a href="{{ route('provinsi.index') }}" class="btn btn-primary">
                        <i class="mr-2">🗺️</i>
                        Provinsi
                    </a>
                    <a href="{{ route('kabupaten.index') }}" class="btn btn-secondary">
                        <i class="mr-2">📍</i>
                        Kabupaten
                    </a>
                    <a href="{{ route('penduduk.index') }}" class="btn btn-accent">
                        <i class="mr-2">👥</i>
                        Penduduk
                    </a>
                    <a href="{{ route('provinsi.laporan') }}" class="btn btn-info">
                        <i class="mr-2">📊</i>
                        Laporan Provinsi
                    </a>
                    <a href="{{ route('kabupaten.laporan') }}" class="btn btn-info">
                        <i class="mr-2">📊</i>
                        Laporan Kabupaten
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Kabupaten by Population -->
    <div class="mt-6">
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">🏆 Top 5 Kabupaten Berdasarkan Jumlah Penduduk</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Jumlah Penduduk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topKabupaten as $index => $kabupaten)
                                <tr>
                                    <td>
                                        <div class="badge badge-primary">{{ $index + 1 }}</div>
                                    </td>
                                    <td>{{ $kabupaten->nama_kabupaten }}</td>
                                    <td>{{ $kabupaten->provinsi->nama_provinsi }}</td>
                                    <td>{{ number_format($kabupaten->penduduk_count) }} orang</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
