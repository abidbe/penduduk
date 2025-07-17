class PaginationComponent {
    constructor(tableId, itemsPerPage = 10) {
        this.tableId = tableId;
        this.itemsPerPage = itemsPerPage;
        this.currentPage = 1;
        this.allRows = [];
        this.filteredRows = [];

        this.prevBtn = document.getElementById("prevBtn");
        this.nextBtn = document.getElementById("nextBtn");
        this.pageInfo = document.getElementById("pageInfo");

        this.init();
    }

    init() {
        setTimeout(() => {
            this.loadRows();
        }, 100);
    }

    loadRows() {
        const tableBody = document.getElementById(this.tableId);
        if (tableBody) {
            // Ambil semua row kecuali noDataRow
            this.allRows = Array.from(
                tableBody.querySelectorAll("tr:not(#noDataRow)")
            );
            this.filteredRows = [...this.allRows]; // Create a copy
            this.update();
        }
    }

    update() {
        const noDataRow = document.getElementById("noDataRow");

        // Jika tidak ada data yang difilter
        if (this.filteredRows.length === 0) {
            // Sembunyikan semua row data
            this.allRows.forEach((row) => (row.style.display = "none"));

            // Tampilkan pesan tidak ada data
            if (noDataRow) {
                noDataRow.style.display = "";
                const tdElement = noDataRow.querySelector("td");
                if (tdElement) {
                    tdElement.innerHTML =
                        '<div class="text-gray-500">Tidak ada data</div>';
                }
            }

            this.updatePagination(0);
            return;
        }

        // Sembunyikan pesan tidak ada data
        if (noDataRow) {
            noDataRow.style.display = "none";
        }

        const totalPages = Math.ceil(
            this.filteredRows.length / this.itemsPerPage
        );
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;

        // Sembunyikan semua row
        this.allRows.forEach((row) => (row.style.display = "none"));

        // Tampilkan row untuk halaman saat ini
        this.filteredRows.slice(startIndex, endIndex).forEach((row) => {
            row.style.display = "";
        });

        // Update nomor urut
        this.filteredRows.slice(startIndex, endIndex).forEach((row, index) => {
            const firstCell = row.cells[0];
            if (firstCell) {
                firstCell.textContent = startIndex + index + 1;
            }
        });

        this.updatePagination(totalPages);
    }

    updatePagination(totalPages) {
        if (this.prevBtn) {
            this.prevBtn.disabled = this.currentPage === 1;
        }
        if (this.nextBtn) {
            this.nextBtn.disabled =
                this.currentPage === totalPages || totalPages === 0;
        }
        if (this.pageInfo) {
            this.pageInfo.textContent =
                totalPages > 0
                    ? `Page ${this.currentPage} of ${totalPages}`
                    : "Page 0 of 0";
        }
    }

    next() {
        const totalPages = Math.ceil(
            this.filteredRows.length / this.itemsPerPage
        );
        if (this.currentPage < totalPages) {
            this.currentPage++;
            this.update();
        }
    }

    prev() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.update();
        }
    }

    filter(filterFunction) {
        this.filteredRows = this.allRows.filter(filterFunction);
        this.currentPage = 1;
        this.update();
    }

    reset() {
        this.filteredRows = [...this.allRows]; // Create a copy
        this.currentPage = 1;
        this.update();
    }

    // Method to refresh rows after CRUD operations
    refreshRows() {
        this.loadRows();
    }
}
