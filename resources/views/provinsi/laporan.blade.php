@extends('layouts.crud-base')

@section('title', 'Laporan Provinsi - Admin Panel')
@section('page-title', '📊 Laporan Provinsi')
@section('search-placeholder', 'Cari provinsi...')
@section('table-id', 'laporanTable')

@section('custom-button')
    <button class="btn btn-success w-full sm:w-auto order-3 sm:order-1" onclick="exportData()">
        <span class="text-lg">📥</span>
        Export Data
    </button>
@endsection

@section('table-headers')
    <th>No</th>
    <th>Nama Provinsi</th>
    <th>Jumlah Penduduk</th>
@endsection

@section('table-rows')
    @php $totalPenduduk = 0; @endphp
    @forelse ($laporanProvinsi as $key => $item)
        @php $totalPenduduk += $item->penduduk_count; @endphp
        <tr>
            <td class="px-4 py-3">{{ $key + 1 }}</td>
            <td class="px-4 py-3">
                <div class="font-medium">{{ $item->nama_provinsi }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="badge badge-primary">{{ number_format($item->penduduk_count) }} orang</div>
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
    @if (count($laporanProvinsi) > 0)
        <tr id="noDataRow" style="display: none;">
            <td colspan="3" class="text-center py-8">
                <div class="text-gray-500">Tidak ada data</div>
            </td>
        </tr>
    @endif
@endsection

@section('additional-content')
    <!-- Summary Card -->
    @if (count($laporanProvinsi) > 0)
        <div class="mt-6 p-4 bg-base-200 rounded-lg">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold">Total Penduduk Seluruh Provinsi:</span>
                <span class="text-xl font-bold text-primary">{{ number_format($totalPenduduk) }} orang</span>
            </div>
        </div>
    @endif
@endsection

@section('modals')
    <!-- Print Modal -->
    <div id="printModal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl">
            <h3 class="font-bold text-lg mb-4">Print Preview</h3>
            <div id="printContent">
                <!-- Content will be populated here -->
            </div>
            <div class="modal-action">
                <button class="btn" onclick="printModal.close()">Tutup</button>
                <button class="btn btn-primary" onclick="printReport()">Print</button>
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

    <script>
        // Initialize components menggunakan komponen yang sudah ada
        const alert = new AlertComponent();
        const printModal = new ModalComponent('printModal');
        const pagination = new PaginationComponent('laporanTable', 10);
        const search = new SearchComponent('searchInput', pagination, [1]); // Search di kolom nama provinsi

        function exportData() {
            alert.show('Export sedang diproses...', 'info');

            // Simulate export process
            setTimeout(() => {
                generatePrintContent();
                printModal.open();
            }, 1000);
        }

        function generatePrintContent() {
            const printContent = document.getElementById('printContent');
            const currentDate = new Date().toLocaleDateString('id-ID');

            let html = `
                <div class="print-area">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold mb-2">LAPORAN JUMLAH PENDUDUK PER PROVINSI</h1>
                        <p class="text-gray-600">Tanggal: ${currentDate}</p>
                    </div>
                    
                    <table class="table table-bordered w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama Provinsi</th>
                                <th class="border px-4 py-2">Jumlah Penduduk</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            // Generate table rows
            @foreach ($laporanProvinsi as $key => $item)
                html += `
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $key + 1 }}</td>
                        <td class="border px-4 py-2">{{ $item->nama_provinsi }}</td>
                        <td class="border px-4 py-2 text-center">{{ number_format($item->penduduk_count) }} orang</td>
                    </tr>
                `;
            @endforeach

            html += `
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td class="border px-4 py-2 text-center" colspan="2">TOTAL</td>
                                <td class="border px-4 py-2 text-center">{{ number_format($totalPenduduk) }} orang</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

            printContent.innerHTML = html;
        }

        function printReport() {
            const printContent = document.getElementById('printContent').innerHTML;
            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Laporan Provinsi</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .bg-gray-100 { background-color: #f7f7f7; }
                        .text-2xl { font-size: 1.5rem; }
                        .mb-8 { margin-bottom: 2rem; }
                        .mb-2 { margin-bottom: 0.5rem; }
                        .text-gray-600 { color: #666; }
                        .border { border: 1px solid #ddd; }
                        .px-4 { padding-left: 1rem; padding-right: 1rem; }
                        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
