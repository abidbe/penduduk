class CascadingFilterComponent {
    constructor(
        parentFilterId,
        childFilterId,
        tableId,
        originalRowsSelector = "tr:not(#noDataRow)"
    ) {
        this.parentFilterId = parentFilterId;
        this.childFilterId = childFilterId;
        this.tableId = tableId;
        this.originalRowsSelector = originalRowsSelector;
        this.originalRows = [];
        this.pagination = null;
        this.search = null;
        this.allChildOptions = [];

        this.init();
    }

    init() {
        // Store original rows on initialization
        this.storeOriginalRows();

        // Store all child options
        this.storeAllChildOptions();

        // Setup filter event listeners
        const parentFilter = document.getElementById(this.parentFilterId);
        const childFilter = document.getElementById(this.childFilterId);

        if (parentFilter) {
            parentFilter.addEventListener("change", () =>
                this.handleParentFilterChange()
            );
        }

        if (childFilter) {
            childFilter.addEventListener("change", () => this.applyFilters());
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

    storeAllChildOptions() {
        const childFilter = document.getElementById(this.childFilterId);
        if (childFilter && childFilter.options) {
            this.allChildOptions = Array.from(childFilter.options).slice(1); // Skip the first "Semua" option
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

    handleParentFilterChange() {
        const parentValue = document.getElementById(this.parentFilterId)?.value;
        const childFilter = document.getElementById(this.childFilterId);

        if (!childFilter) return;

        // Clear child filter
        childFilter.innerHTML = '<option value="">Semua Kabupaten</option>';

        if (parentValue) {
            // Filter child options based on parent value
            const filteredOptions = this.allChildOptions.filter(
                (option) =>
                    option.getAttribute("data-provinsi-id") === parentValue
            );

            // Add filtered options to child filter
            filteredOptions.forEach((option) => {
                const newOption = option.cloneNode(true);
                childFilter.appendChild(newOption);
            });
        } else {
            // If no parent selected, show all child options
            this.allChildOptions.forEach((option) => {
                const newOption = option.cloneNode(true);
                childFilter.appendChild(newOption);
            });
        }

        // Reset child filter value
        childFilter.value = "";

        // Apply filters
        this.applyFilters();
    }

    applyFilters() {
        const parentValue = document.getElementById(this.parentFilterId)?.value;
        const childValue = document.getElementById(this.childFilterId)?.value;
        const tbody = document.getElementById(this.tableId);
        const noDataRow = document.getElementById("noDataRow");

        if (!tbody) return;

        // Clear current rows (except noDataRow)
        const currentRows = tbody.querySelectorAll(this.originalRowsSelector);
        currentRows.forEach((row) => row.remove());

        let filteredRows = [...this.originalRows]; // Create a copy

        // Apply parent filter
        if (parentValue) {
            filteredRows = filteredRows.filter(
                (row) => row.getAttribute("data-provinsi-id") === parentValue
            );
        }

        // Apply child filter
        if (childValue) {
            filteredRows = filteredRows.filter(
                (row) => row.getAttribute("data-kabupaten-id") === childValue
            );
        }

        // Add filtered rows back and update row numbers
        filteredRows.forEach((row, index) => {
            const numberCell = row.querySelector("td:first-child");
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
            if (noDataRow) {
                tbody.insertBefore(row, noDataRow);
            } else {
                tbody.appendChild(row);
            }
        });

        // Show/hide no data row
        if (noDataRow) {
            if (filteredRows.length === 0) {
                noDataRow.style.display = "";
            } else {
                noDataRow.style.display = "none";
            }
        }

        // Reset pagination and search
        if (this.pagination) {
            this.pagination.refreshRows();
        }
        if (this.search) {
            this.search.clear();
        }
    }

    reset() {
        const parentFilter = document.getElementById(this.parentFilterId);
        const childFilter = document.getElementById(this.childFilterId);

        if (parentFilter) {
            parentFilter.value = "";
        }

        if (childFilter) {
            childFilter.innerHTML = '<option value="">Semua Kabupaten</option>';
            this.allChildOptions.forEach((option) => {
                const newOption = option.cloneNode(true);
                childFilter.appendChild(newOption);
            });
            childFilter.value = "";
        }

        this.applyFilters();
    }

    // Method to refresh original rows (useful after CRUD operations)
    refreshOriginalRows() {
        this.storeOriginalRows();
        this.storeAllChildOptions();
    }

    // Method to get current filtered rows
    getCurrentFilteredRows() {
        const tbody = document.getElementById(this.tableId);
        return tbody
            ? Array.from(tbody.querySelectorAll(this.originalRowsSelector))
            : [];
    }

    // Method to get filter values
    getFilterValues() {
        return {
            parent: document.getElementById(this.parentFilterId)?.value || "",
            child: document.getElementById(this.childFilterId)?.value || "",
        };
    }
}
