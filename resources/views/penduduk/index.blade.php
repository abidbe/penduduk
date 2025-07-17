@extends('layouts.crud-base')

@section('title', 'Data Penduduk - Admin Panel')
@section('page-title', '👥 Data Penduduk')
@section('search-placeholder', 'Cari Penduduk...')
@section('table-id', 'pendudukTable')

@section('filters')
    <div class="form-control w-full sm:w-auto">
        <select id="provinsiFilter" class="select select-bordered w-full sm:w-48">
            <option value="">Semua Provinsi</option>
            @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-control w-full sm:w-auto">
        <select id="kabupatenFilter" class="select select-bordered w-full sm:w-48">
            <option value="">Semua Kabupaten</option>
            @foreach ($kabupaten as $kab)
                <option value="{{ $kab->id }}" data-provinsi-id="{{ $kab->provinsi_id }}">{{ $kab->nama_kabupaten }}
                </option>
            @endforeach
        </select>
    </div>
@endsection

@section('table-headers')
    <th>No</th>
    <th>NIK</th>
    <th>Nama</th>
    <th>Kabupaten/Kota</th>
    <th>Umur</th>
    <th>Alamat</th>
    <th>Aksi</th>
@endsection

@section('table-rows')
    @forelse ($penduduk as $key => $item)
        <tr data-provinsi-id="{{ $item->kabupaten->provinsi_id }}" data-kabupaten-id="{{ $item->kabupaten_id }}">
            <td class="px-4 py-3">{{ $key + 1 }}</td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->nik }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->nama }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->kabupaten->nama_kabupaten }}</div>
                <div class="text-sm opacity-50">{{ $item->kabupaten->provinsi->nama_provinsi }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->umur }} tahun</div>
            </td>
            <td class="px-4 py-3">
                <div class="font-medium max-w-xs truncate">{{ $item->alamat }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-2">
                    <button class="btn btn-sm btn-warning w-full sm:w-auto"
                        onclick="editPenduduk({{ $item->id }}, '{{ $item->nik }}', '{{ $item->nama }}', {{ $item->kabupaten_id }}, {{ $item->umur }}, '{{ $item->alamat }}')">
                        <span class="hidden sm:inline">🔨</span>
                        <span class="sm:hidden">Edit</span>
                        <span class="hidden sm:inline ml-1">Edit</span>
                    </button>
                    <button class="btn btn-sm btn-error text-white w-full sm:w-auto"
                        onclick="deletePenduduk({{ $item->id }}, '{{ $item->nama }}')">
                        <span class="hidden sm:inline">🗑️</span>
                        <span class="sm:hidden">Hapus</span>
                        <span class="hidden sm:inline ml-1">Hapus</span>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr id="noDataRow">
            <td colspan="7" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endforelse

    <!-- Hidden row untuk search result kosong -->
    @if (count($penduduk) > 0)
        <tr id="noDataRow" style="display: none;">
            <td colspan="7" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endif
@endsection

@section('modals')
    <!-- Add/Edit Modal -->
    <div id="pendudukModal" class="modal">
        <div class="modal-box w-11/12 max-w-lg mx-auto">
            <h3 class="font-bold text-lg mb-4" id="modalTitle">Tambah Penduduk</h3>
            <form id="pendudukForm">
                @csrf
                <input type="hidden" id="pendudukId" name="id">

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">NIK</span>
                    </label>
                    <input type="text" id="nik" name="nik" placeholder="Masukkan NIK"
                        class="input input-bordered w-full" required maxlength="16" />
                    <div id="nikError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama"
                        class="input input-bordered w-full" required />
                    <div id="namaError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Provinsi</span>
                    </label>
                    <select id="provinsiSelect" class="select select-bordered w-full" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                        @endforeach
                    </select>
                    <div id="provinsiError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Kabupaten</span>
                    </label>
                    <select id="kabupatenId" name="kabupaten_id" class="select select-bordered w-full" required>
                        <option value="">Pilih Kabupaten</option>
                    </select>
                    <div id="kabupaten_idError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Umur</span>
                    </label>
                    <input type="number" id="umur" name="umur" placeholder="Masukkan umur"
                        class="input input-bordered w-full" required min="0" max="150" />
                    <div id="umurError" class="text-error text-sm mt-1 hidden"></div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Alamat</span>
                    </label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat" class="textarea textarea-bordered w-full"
                        required rows="3"></textarea>
                    <div id="alamatError" class="text-error text-sm mt-1 hidden"></div>
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
            <p class="py-4">Apakah Anda yakin ingin menghapus data penduduk <span id="deletePendudukName"
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
    <script src="{{ asset('js/components/cascading-filter.js') }}"></script>

    <script>
        // Initialize components
        const alert = new AlertComponent();
        const modal = new ModalComponent('pendudukModal');
        const deleteModal = new ModalComponent('deleteModal');
        const pagination = new PaginationComponent('pendudukTable', 10);
        const search = new SearchComponent('searchInput', pagination, [1, 2, 3]); // Search on NIK, Nama, Kabupaten
        const crud = new CrudHandler('/penduduk', alert);
        const formHandler = new FormHandler('pendudukForm', modal, crud);

        // Initialize cascading filter component
        const cascadingFilter = new CascadingFilterComponent('provinsiFilter', 'kabupatenFilter', 'pendudukTable')
            .setPagination(pagination)
            .setSearch(search);

        let currentDeleteId = null;

        // Load kabupaten when provinsi changes in form
        document.getElementById('provinsiSelect').addEventListener('change', function() {
            const provinsiId = this.value;
            const kabupatenSelect = document.getElementById('kabupatenId');

            // Clear kabupaten options
            kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';

            if (provinsiId) {
                // Fetch kabupaten based on provinsi
                fetch(`/penduduk/kabupaten/${provinsiId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kabupaten => {
                            const option = document.createElement('option');
                            option.value = kabupaten.id;
                            option.textContent = kabupaten.nama_kabupaten;
                            kabupatenSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Penduduk';
            formHandler.reset();
            document.getElementById('pendudukId').value = '';
            document.getElementById('provinsiSelect').value = '';
            document.getElementById('kabupatenId').innerHTML = '<option value="">Pilih Kabupaten</option>';
            modal.open();
        }

        function editPenduduk(id, nik, nama, kabupatenId, umur, alamat) {
            document.getElementById('modalTitle').innerText = 'Edit Penduduk';

            // Find the kabupaten's provinsi_id
            const kabupatenData = @json($kabupaten);
            const selectedKabupaten = kabupatenData.find(k => k.id === kabupatenId);

            if (selectedKabupaten) {
                // Set provinsi first
                document.getElementById('provinsiSelect').value = selectedKabupaten.provinsi_id;

                // Load kabupaten for the selected provinsi
                fetch(`/penduduk/kabupaten/${selectedKabupaten.provinsi_id}`)
                    .then(response => response.json())
                    .then(data => {
                        const kabupatenSelect = document.getElementById('kabupatenId');
                        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';
                        data.forEach(kabupaten => {
                            const option = document.createElement('option');
                            option.value = kabupaten.id;
                            option.textContent = kabupaten.nama_kabupaten;
                            kabupatenSelect.appendChild(option);
                        });

                        // Set the selected kabupaten
                        kabupatenSelect.value = kabupatenId;
                    });
            }

            formHandler.populate({
                id: id,
                nik: nik,
                nama: nama,
                kabupaten_id: kabupatenId,
                umur: umur,
                alamat: alamat
            });

            modal.open();
        }

        function deletePenduduk(id, nama) {
            currentDeleteId = id;
            document.getElementById('deletePendudukName').innerText = nama;
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
