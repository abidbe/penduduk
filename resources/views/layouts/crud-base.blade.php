@extends('welcome')

@section('content')
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <!-- Header Section -->
            <div class="flex w-full justify-center mb-6">
                <h2 class="text-3xl card-title mb-4">@yield('page-title')</h2>
            </div>

            <!-- Action Bar -->
            <div class="flex justify-between items-center mb-6">
                <button class="btn btn-primary" onclick="openAddModal()">
                    <span class="text-xl">+</span>
                    Tambah
                </button>
                <div class="form-control">
                    <input type="text" id="searchInput" placeholder="@yield('search-placeholder')"
                        class="input input-bordered w-64" />
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            @yield('table-headers')
                        </tr>
                    </thead>
                    <tbody id="@yield('table-id')">
                        @yield('table-rows')
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-end mt-6">
                <div class="join">
                    <button class="join-item btn" id="prevBtn" onclick="pagination.prev()">«</button>
                    <button class="join-item btn" id="pageInfo">Page 1</button>
                    <button class="join-item btn" id="nextBtn" onclick="pagination.next()">»</button>
                </div>
            </div>
        </div>
    </div>

    @yield('modals')
    @yield('alerts')
    @yield('scripts')
@endsection
