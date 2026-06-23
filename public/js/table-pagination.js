class CustomPaginator {
    constructor(tableBodySelector, rowsPerPage = 10) {
        this.tbody = document.querySelector(tableBodySelector);
        if (!this.tbody) return;

        this.table = this.tbody.closest('table');
        this.rowsPerPage = rowsPerPage;
        this.currentPage = 1;
        this.allRows = Array.from(this.tbody.querySelectorAll('tr:not(.no-data-row)'));
        this.filteredRows = [...this.allRows];

        // Create pagination container
        this.pagerContainer = document.createElement('div');
        this.pagerContainer.className = 'custom-pagination';

        // Find table-card wrapper to append to, or just insert after table wrapper
        const tableResponsive = this.table.closest('.table-responsive');
        if (tableResponsive) {
            tableResponsive.parentNode.insertBefore(this.pagerContainer, tableResponsive.nextSibling);
        } else {
            this.table.parentNode.insertBefore(this.pagerContainer, this.table.nextSibling);
        }

        // Hook into click events for pagination
        this.pagerContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.custom-pagination__btn');
            if (!btn || btn.disabled) return;

            const page = parseInt(btn.dataset.page);
            if (!isNaN(page)) {
                this.goToPage(page);
            }
        });

        // Initial setup: hide all rows first, then update
        this.allRows.forEach(row => {
            // we use a custom data attribute to track visibility independent of simple display none
            if (!row.hasAttribute('data-visible-by-filter')) {
                row.setAttribute('data-visible-by-filter', 'true');
            }
        });

        this.update();
    }

    // Call this whenever external search/filter modifies row visibility
    // Pass a function that evaluates each row and returns true if it should be visible
    applyFilter(filterFn) {
        this.filteredRows = [];
        let hasVisible = false;

        this.allRows.forEach(row => {
            if (filterFn(row)) {
                this.filteredRows.push(row);
                row.setAttribute('data-visible-by-filter', 'true');
                hasVisible = true;
            } else {
                row.setAttribute('data-visible-by-filter', 'false');
                row.style.display = 'none'; // hide immediately
            }
        });

        // Handle empty state
        let noDataRow = this.tbody.querySelector('.no-data-row');
        if (!hasVisible && this.allRows.length > 0) {
            if (!noDataRow) {
                noDataRow = document.createElement('tr');
                noDataRow.className = 'no-data-row';
                const colCount = this.allRows[0].children.length;
                noDataRow.innerHTML = `<td colspan="${colCount}" style="text-align:center; padding:3rem 1rem;">
                    <span class="material-symbols-outlined" style="font-size:2.5rem; color:var(--admin-outline); display:block; margin-bottom:0.5rem;">search_off</span>
                    <p style="color:var(--admin-secondary); font-size:0.85rem; margin:0;">Data tidak ditemukan</p>
                </td>`;
                this.tbody.appendChild(noDataRow);
            }
            noDataRow.style.display = '';
        } else if (noDataRow) {
            noDataRow.style.display = 'none';
        }

        this.currentPage = 1;
        this.update();
    }

    goToPage(page) {
        this.currentPage = page;
        this.update();
    }

    update() {
        const totalRows = this.filteredRows.length;
        const totalPages = Math.ceil(totalRows / this.rowsPerPage) || 1;

        if (this.currentPage > totalPages) this.currentPage = totalPages;
        if (this.currentPage < 1) this.currentPage = 1;

        // Hide all rows first (only care about those passing filter)
        this.filteredRows.forEach(row => {
            row.style.display = 'none';
        });

        // Show rows for current page
        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = start + this.rowsPerPage;
        for (let i = start; i < end && i < totalRows; i++) {
            this.filteredRows[i].style.display = ''; // revert to default
        }

        this.renderControls(totalRows, totalPages);
        
        // Hide existing custom table footer if it exists
        const tableFooter = this.pagerContainer.parentNode.querySelector('.table-footer');
        if (tableFooter && tableFooter !== this.pagerContainer) {
            tableFooter.style.display = 'none';
        }
    }

    renderControls(totalRows, totalPages) {
        if (totalRows === 0) {
            this.pagerContainer.style.display = 'none';
            return;
        }
        
        this.pagerContainer.style.display = 'flex';

        const startLabel = (this.currentPage - 1) * this.rowsPerPage + 1;
        const endLabel = Math.min(this.currentPage * this.rowsPerPage, totalRows);

        let html = `
            <div class="custom-pagination__info">
                Menampilkan ${startLabel}-${endLabel} dari ${totalRows} data
            </div>
            <div class="custom-pagination__controls">
                <button type="button" class="custom-pagination__btn" data-page="${this.currentPage - 1}" ${this.currentPage === 1 ? 'disabled' : ''}>
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">chevron_left</span>
                </button>
        `;

        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                html += `
                    <button type="button" class="custom-pagination__btn ${i === this.currentPage ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === this.currentPage - 2 || i === this.currentPage + 2) {
                html += `<span class="custom-pagination__dots">...</span>`;
            }
        }

        html += `
                <button type="button" class="custom-pagination__btn" data-page="${this.currentPage + 1}" ${this.currentPage === totalPages ? 'disabled' : ''}>
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">chevron_right</span>
                </button>
            </div>
        `;

        this.pagerContainer.innerHTML = html;
    }
}
