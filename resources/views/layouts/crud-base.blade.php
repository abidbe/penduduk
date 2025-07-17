@extends('welcome')

@section('content')
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-4 sm:p-6">
            <!-- Header Section -->
            <div class="flex w-full justify-center mb-6">
                <h2 class="text-2xl sm:text-3xl card-title mb-4 text-center">@yield('page-title')</h2>
            </div>

            <!-- Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                @hasSection('custom-button')
                    @yield('custom-button')
                @else
                    <button class="btn btn-primary w-full sm:w-auto order-3 sm:order-1" onclick="openAddModal()">
                        <span class="text-xl">+</span>
                        Tambah
                    </button>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto order-1 sm:order-2">
                    @yield('filters')
                    <div class="form-control w-full sm:w-auto">
                        <input type="text" id="searchInput" placeholder="@yield('search-placeholder')"
                            class="input input-bordered w-full sm:w-64" />
                    </div>
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

            <!-- Additional Content -->
            @yield('additional-content')

            <!-- Pagination -->
            <div class="flex justify-center sm:justify-end mt-6">
                <div class="join">
                    <button class="join-item btn btn-sm sm:btn-md" id="prevBtn" onclick="pagination.prev()">
                        <span class="hidden sm:inline">«</span>
                        <span class="sm:hidden">Prev</span>
                    </button>
                    <button class="join-item btn btn-sm sm:btn-md" id="pageInfo">Page 1</button>
                    <button class="join-item btn btn-sm sm:btn-md" id="nextBtn" onclick="pagination.next()">
                        <span class="hidden sm:inline">»</span>
                        <span class="sm:hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @yield('modals')
    @yield('alerts')
    @yield('scripts')
@endsection
