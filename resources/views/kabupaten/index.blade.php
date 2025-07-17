@extends('layouts.crud-base')

@section('title', 'Data Kabupaten/Kota - Admin Panel')
@section('page-title', '🏘️ Data Kabupaten/Kota')
@section('search-placeholder', 'Cari Kabupaten/Kota...')
@section('table-id', 'kabupatenTable')

@section('filters')
    <div class="form-control w-full sm:w-auto">
        <select id="provinsiFilter" class="select select-bordered w-full sm:w-48">
            <option value="">Semua Provinsi</option>
            @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
            @endforeach
        </select>
    </div>
@endsection

@section('table-headers')
    <th>No</th>
    <th>Nama Kabupaten/Kota</th>
    <th>Provinsi</th>
    <th>Aksi</th>
@endsection

@section('table-rows')
    @forelse ($kabupaten as $key => $item)
        <tr data-provinsi-id="{{ $item->provinsi_id }}">
            <td class="px-2 py-3">{{ $key + 1 }}</td>
            <td class="px-2 py-3">
                <div class="font-medium">{{ $item->nama_kabupaten }}</div>
            </td>
            <td class="px-2 py-3">
                <div class="font-medium">{{ $item->provinsi->nama_provinsi }}</div>
            </td>
            <td class="px-2 py-3">
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-2">
                    <button class="btn btn-sm btn-warning w-full sm:w-auto"
                        onclick="editKabupaten({{ $item->id }}, '{{ $item->nama_kabupaten }}', {{ $item->provinsi_id }})">
                        <span class="hidden sm:inline">🔨</span>
                        <span class="sm:hidden">Edit</span>
                        <span class="hidden sm:inline ml-1">Edit</span>
                    </button>
                    <button class="btn btn-sm btn-error text-white w-full sm:w-auto"
                        onclick="deleteKabupaten({{ $item->id }}, '{{ $item->nama_kabupaten }}')">
                        <span class="hidden sm:inline">🗑️</span>
                        <span class="sm:hidden">Hapus</span>
                        <span class="hidden sm:inline ml-1">Hapus</span>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr id="noDataRow">
            <td colspan="4" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endforelse

    <!-- Hidden row untuk search result kosong -->
    @if (count($kabupaten) > 0)
        <tr id="noDataRow" style="display: none;">
            <td colspan="4" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endif
@endsection

@section('modals')
    <!-- Add/Edit Modal -->
    <div id="kabupatenModal" class="modal">
        <div class="modal-box w-11/12 max-w-md mx-auto">
            <h3 class="font-bold text-lg mb-4" id="modalTitle">Tambah Kabupaten/Kota</h3>
            <form id="kabupatenForm">
                @csrf
                <input type="hidden" id="kabupatenId" name="id">

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Nama Kabupaten/Kota</span>
                    </label>
                    <input type="text" id="namaKabupaten" name="nama_kabupaten"
                        placeholder="Masukkan nama Kabupaten/Kota" class="input input-bordered w-full" required />
                    <div id="nama_kabupatenError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Provinsi</span>
                    </label>
                    <select id="provinsiId" name="provinsi_id" class="select select-bordered w-full" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                        @endforeach
                    </select>
                    <div id="provinsi_idError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="modal-action flex flex-col sm:flex-row gap-2">
                    <button type="button" class="btn btn-ghost w-full sm:w-auto order-2 sm:order-1"
                        onclick="modal.close()">Batal</button>
                    <button type="submit" class="btn btn-primary w-full sm:w-auto order-1 sm:order-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-box w-11/12 max-w-md mx-auto">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="py-4">Apakah Anda yakin ingin menghapus Kabupaten/Kota <span id="deleteKabupatenName"
                    class="font-bold"></span>?</p>
            <div class="modal-action flex flex-col sm:flex-row gap-2">
                <button class="btn btn-ghost w-full sm:w-auto order-2 sm:order-1"
                    onclick="deleteModal.close()">Batal</button>
                <button class="btn btn-error w-full sm:w-auto order-1 sm:order-2" onclick="confirmDelete()">Hapus</button>
            </div>
        </div>
    </div>
@endsection

@section('alerts')
    <div id="alertContainer" class="toast toast-top toast-end" style="display: none;">
        <div class="text-white alert" id="alertBox">
            <span id="alertMessage"></span>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/components/alert.js') }}"></script>
    <script src="{{ asset('js/components/modal.js') }}"></script>
    <script src="{{ asset('js/components/pagination.js') }}"></script>
    <script src="{{ asset('js/components/search.js') }}"></script>
    <script src="{{ asset('js/components/crud.js') }}"></script>
    <script src="{{ asset('js/components/form.js') }}"></script>
    <script src="{{ asset('js/components/filter.js') }}"></script>

    <script>
        // Initialize components
        const alert = new AlertComponent();
        const modal = new ModalComponent('kabupatenModal');
        const deleteModal = new ModalComponent('deleteModal');
        const pagination = new PaginationComponent('kabupatenTable', 10);
        const search = new SearchComponent('searchInput', pagination, [1, 2]); // Search on nama_kabupaten and provinsi
        const crud = new CrudHandler('/kabupaten', alert);
        const formHandler = new FormHandler('kabupatenForm', modal, crud);

        // Initialize filter component
        const provinsiFilter = new FilterComponent('provinsiFilter', 'kabupatenTable', 'data-provinsi-id')
            .setPagination(pagination)
            .setSearch(search);

        let currentDeleteId = null;

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Kabupaten';
            formHandler.reset();
            document.getElementById('kabupatenId').value = '';
            document.getElementById('provinsiId').value = '';
            modal.open();
        }

        function editKabupaten(id, nama, provinsiId) {
            document.getElementById('modalTitle').innerText = 'Edit Kabupaten';
            formHandler.populate({
                id: id,
                nama_kabupaten: nama,
                provinsi_id: provinsiId
            });
            modal.open();
        }

        function deleteKabupaten(id, nama) {
            currentDeleteId = id;
            document.getElementById('deleteKabupatenName').innerText = nama;
            deleteModal.open();
        }

        function confirmDelete() {
            if (currentDeleteId) {
                crud.handleDelete(currentDeleteId, () => {
                    deleteModal.close();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                });
            }
        }
    </script>
@endsection
