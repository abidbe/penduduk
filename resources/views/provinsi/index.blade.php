@extends('layouts.crud-base')

@section('title', 'Data Provinsi - Admin Panel')
@section('page-title', '📍 Data Provinsi')
@section('search-placeholder', 'Cari provinsi...')
@section('table-id', 'provinsiTable')

@section('table-headers')
    <th>No</th>
    <th>Nama Provinsi</th>
    <th>Aksi</th>
@endsection

@section('table-rows')
    @forelse ($provinsi as $key => $item)
        <tr>
            <td class="px-4 py-3">{{ $key + 1 }}</td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->nama_provinsi }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-2">
                    <button class="btn btn-sm btn-warning w-full sm:w-auto"
                        onclick="editProvinsi({{ $item->id }}, '{{ $item->nama_provinsi }}')">
                        <span class="hidden sm:inline">🔨</span>
                        <span class="sm:hidden">Edit</span>
                        <span class="hidden sm:inline ml-1">Edit</span>
                    </button>
                    <button class="btn btn-sm btn-error text-white w-full sm:w-auto"
                        onclick="deleteProvinsi({{ $item->id }}, '{{ $item->nama_provinsi }}')">
                        <span class="hidden sm:inline">🗑️</span>
                        <span class="sm:hidden">Hapus</span>
                        <span class="hidden sm:inline ml-1">Hapus</span>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr id="noDataRow">
            <td colspan="3" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endforelse

    <!-- Hidden row untuk search result kosong -->
    @if (count($provinsi) > 0)
        <tr id="noDataRow" style="display: none;">
            <td colspan="3" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endif
@endsection

@section('modals')
    <!-- Add/Edit Modal -->
    <div id="provinsiModal" class="modal">
        <div class="modal-box w-11/12 max-w-md mx-auto">
            <h3 class="font-bold text-lg mb-4" id="modalTitle">Tambah Provinsi</h3>
            <form id="provinsiForm">
                @csrf
                <input type="hidden" id="provinsiId" name="id">
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Nama Provinsi</span>
                    </label>
                    <input type="text" id="namaProvinsi" name="nama_provinsi" placeholder="Masukkan nama provinsi"
                        class="input input-bordered w-full" required />
                    <div id="nama_provinsiError" class="text-error text-sm mt-1 hidden"></div>
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
            <p class="py-4">Apakah Anda yakin ingin menghapus provinsi <span id="deleteProvinsiName"
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
    <div id="alertContainer" class="toast toast-top toast-end" style="display: none; z-index: 9999;">
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

    <script>
        // Initialize components
        const alert = new AlertComponent();
        const modal = new ModalComponent('provinsiModal');
        const deleteModal = new ModalComponent('deleteModal');
        const pagination = new PaginationComponent('provinsiTable', 10);
        const search = new SearchComponent('searchInput', pagination, [1]);
        const crud = new CrudHandler('/provinsi', alert);
        const formHandler = new FormHandler('provinsiForm', modal, crud);

        let currentDeleteId = null;

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Provinsi';
            formHandler.reset();
            document.getElementById('provinsiId').value = '';
            modal.open();
        }

        function editProvinsi(id, nama) {
            document.getElementById('modalTitle').innerText = 'Edit Provinsi';
            formHandler.populate({
                id: id,
                nama_provinsi: nama
            });
            modal.open();
        }

        function deleteProvinsi(id, nama) {
            currentDeleteId = id;
            document.getElementById('deleteProvinsiName').innerText = nama;
            deleteModal.open();
        }

        function confirmDelete() {
            if (currentDeleteId) {
                crud.handleDelete(currentDeleteId, () => {
                    deleteModal.close();
                    setTimeout(() => location.reload(), 1000);
                });
            }
        }
    </script>
@endsection
