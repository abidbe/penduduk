class SearchComponent {
    constructor(inputId, pagination, searchColumns = [1]) {
        this.input = document.getElementById(inputId);
        this.pagination = pagination;
        this.searchColumns = Array.isArray(searchColumns)
            ? searchColumns
            : [searchColumns];
        this.init();
    }

    init() {
        if (this.input) {
            this.input.addEventListener("input", (e) => {
                this.search(e.target.value);
            });
        }
    }

    search(searchTerm) {
        const term = searchTerm.toLowerCase().trim();

        if (term === "") {
            this.pagination.reset();
            return;
        }

        this.pagination.filter((row) => {
            return this.searchColumns.some((columnIndex) => {
                const cell = row.cells[columnIndex];
                if (!cell) return false;
                const cellText = cell.textContent.toLowerCase();
                return cellText.includes(term);
            });
        });
    }

    clear() {
        if (this.input) {
            this.input.value = "";
        }
        this.pagination.reset();
    }

    reset() {
        this.clear();
    }
}
