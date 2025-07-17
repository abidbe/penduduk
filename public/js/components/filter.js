class FilterComponent {
    constructor(
        filterId,
        tableId,
        dataAttribute,
        originalRowsSelector = "tr:not(#noDataRow)"
    ) {
        this.filterId = filterId;
        this.tableId = tableId;
        this.dataAttribute = dataAttribute;
        this.originalRowsSelector = originalRowsSelector;
        this.originalRows = [];
        this.pagination = null;
        this.search = null;

        this.init();
    }

    init() {
        // Store original rows on initialization
        this.storeOriginalRows();

        // Setup filter event listener
        const filterElement = document.getElementById(this.filterId);
        if (filterElement) {
            filterElement.addEventListener("change", () => this.applyFilter());
        }
    }

    storeOriginalRows() {
        const tbody = document.getElementById(this.tableId);
        if (tbody) {
            this.originalRows = Array.from(
                tbody.querySelectorAll(this.originalRowsSelector)
            );
        }
    }

    setPagination(pagination) {
        this.pagination = pagination;
        return this;
    }

    setSearch(search) {
        this.search = search;
        return this;
    }

    applyFilter() {
        const filterValue = document.getElementById(this.filterId).value;
        const tbody = document.getElementById(this.tableId);
        const noDataRow = document.getElementById("noDataRow");

        if (!tbody || !noDataRow) return;

        // Clear current rows (except noDataRow)
        const currentRows = tbody.querySelectorAll(this.originalRowsSelector);
        currentRows.forEach((row) => row.remove());

        let filteredRows = this.originalRows;

        // Apply filter if value is selected
        if (filterValue) {
            filteredRows = this.originalRows.filter((row) => {
                return row.getAttribute(this.dataAttribute) === filterValue;
            });
        }

        // Add filtered rows back and update row numbers
        filteredRows.forEach((row, index) => {
            const numberCell = row.querySelector("td:first-child");
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
            tbody.insertBefore(row, noDataRow);
        });

        // Show/hide no data row
        if (filteredRows.length === 0) {
            noDataRow.style.display = "";
        } else {
            noDataRow.style.display = "none";
        }

        // Reset pagination and search
        if (this.pagination) {
            this.pagination.reset();
        }
        if (this.search) {
            this.search.reset();
        }
    }

    reset() {
        const filterElement = document.getElementById(this.filterId);
        if (filterElement) {
            filterElement.value = "";
            this.applyFilter();
        }
    }

    // Method to refresh original rows (useful after CRUD operations)
    refreshOriginalRows() {
        this.storeOriginalRows();
    }

    // Method to get current filtered rows
    getCurrentFilteredRows() {
        const tbody = document.getElementById(this.tableId);
        return tbody
            ? Array.from(tbody.querySelectorAll(this.originalRowsSelector))
            : [];
    }

    // Method to get filter value
    getFilterValue() {
        const filterElement = document.getElementById(this.filterId);
        return filterElement ? filterElement.value : "";
    }
}
