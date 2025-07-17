@extends('welcome')

@section('title', 'Data Provinsi - Admin Panel')
@section('page-title', 'Data Provinsi')

@section('content')
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">

            <!-- Header Section -->
            <div class="flex w-full justify-center mb-6">
                <h2 class="text-3xl card-title mb-4">📍 Data Provinsi</h2>
            </div>

            <div class="md:w-full flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <!-- Add Button -->
                <button class="btn btn-primary" onclick="openAddModal()">
                    <span class="text-xl">+</span>
                    Tambah
                </button>
                <!-- Search -->
                <div class="form-control">
                    <input type="text" id="searchInput" placeholder="Cari provinsi..."
                        class="input input-bordered w-full md:w-64" />
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Provinsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="provinsiTable">
                        @foreach ($provinsi as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama_provinsi }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-sm btn-warning"
                                            onclick="editProvinsi({{ $item->id }}, '{{ $item->nama_provinsi }}')">
                                            <span class="text-xl">🔨</span>
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-error text-white"
                                            onclick="deleteProvinsi({{ $item->id }}, '{{ $item->nama_provinsi }}')">
                                            <span class="text-xl">🗑️</span>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-end mt-6">
                <div class="join">
                    <button class="join-item btn" id="prevBtn" onclick="prevPage()">«</button>
                    <button class="join-item btn" id="pageInfo">Page 1</button>
                    <button class="join-item btn" id="nextBtn" onclick="nextPage()">»</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <div id="alertContainer" class="toast toast-top toast-end" style="display: none;">
        <div class="text-white alert" id="alertBox">
            <span id="alertMessage"></span>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="provinsiModal" class="modal">
        <div class="modal-box">
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
                    <div id="namaProvinsiError" class="text-error text-sm mt-1 hidden"></div>
                </div>
                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="py-4">Apakah Anda yakin ingin menghapus provinsi <span id="deleteProvinsiName"
                    class="font-bold"></span>?</p>
            <div class="modal-action">
                <button class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
                <button class="btn btn-error" onclick="confirmDelete()">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;
        let currentPage = 1;
        const itemsPerPage = 10;
        let allRows = [];
        let filteredRows = [];

        // Initialize pagination
        document.addEventListener('DOMContentLoaded', function() {
            allRows = Array.from(document.querySelectorAll('#provinsiTable tr'));
            filteredRows = allRows;
            updatePagination();
        });

        // Show Alert
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');

            alertMessage.textContent = message;
            alertBox.className = `alert alert-${type}`;
            alertContainer.style.display = 'block';

            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 3000);
        }

        // Pagination functions
        function updatePagination() {
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            // Hide all rows
            allRows.forEach(row => row.style.display = 'none');

            // Show current page rows
            filteredRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

            // Update row numbers
            filteredRows.slice(startIndex, endIndex).forEach((row, index) => {
                row.cells[0].textContent = startIndex + index + 1;
            });

            // Update pagination buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            filteredRows = allRows.filter(row => {
                const namaProvinsi = row.cells[1].textContent.toLowerCase();
                return namaProvinsi.includes(searchTerm);
            });

            currentPage = 1;
            updatePagination();
        });

        // Open Add Modal
        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Provinsi';
            document.getElementById('provinsiForm').reset();
            document.getElementById('provinsiId').value = '';
            document.getElementById('namaProvinsiError').classList.add('hidden');
            document.getElementById('provinsiModal').classList.add('modal-open');
        }

        // Edit Provinsi
        function editProvinsi(id, nama) {
            document.getElementById('modalTitle').innerText = 'Edit Provinsi';
            document.getElementById('provinsiId').value = id;
            document.getElementById('namaProvinsi').value = nama;
            document.getElementById('namaProvinsiError').classList.add('hidden');
            document.getElementById('provinsiModal').classList.add('modal-open');
        }

        // Close Modal
        function closeModal() {
            document.getElementById('provinsiModal').classList.remove('modal-open');
        }

        // Delete Provinsi
        function deleteProvinsi(id, nama) {
            currentDeleteId = id;
            document.getElementById('deleteProvinsiName').innerText = nama;
            document.getElementById('deleteModal').classList.add('modal-open');
        }

        // Close Delete Modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('modal-open');
            currentDeleteId = null;
        }

        // Confirm Delete
        function confirmDelete() {
            if (currentDeleteId) {
                fetch(`/provinsi/${currentDeleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Provinsi berhasil dihapus', 'success');
                            closeDeleteModal();
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showAlert('Gagal menghapus data', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Terjadi kesalahan', 'error');
                    });
            }
        }

        // Form Submit
        document.getElementById('provinsiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = document.getElementById('provinsiId').value;
            const url = id ? `/provinsi/${id}` : '/provinsi';
            const method = id ? 'PUT' : 'POST';

            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const message = id ? 'Provinsi berhasil diupdate' : 'Provinsi berhasil ditambahkan';
                        showAlert(message, 'success');
                        closeModal();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if (data.errors && data.errors.nama_provinsi) {
                            document.getElementById('namaProvinsiError').innerText = data.errors.nama_provinsi[
                                0];
                            document.getElementById('namaProvinsiError').classList.remove('hidden');
                        } else {
                            showAlert('Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan', 'error');
                });
        });
    </script>
@endsection
