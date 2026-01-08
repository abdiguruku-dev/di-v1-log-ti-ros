/* =========================================
   DATAGRID / ADVANCED TABLES LOGIC
   ========================================= */

export function initDatagrid() {
    // 1. Logic "Select All" Checkbox
    const checkAllBtn = document.getElementById('checkbox-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    if (checkAllBtn) {
        checkAllBtn.addEventListener('change', function() {
            const isChecked = this.checked;
            
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                
                // Optional: Tambah class highlight ke baris tabel
                const row = checkbox.closest('tr');
                if (isChecked) {
                    row.classList.add('selected', 'bg-blue-50'); 
                } else {
                    row.classList.remove('selected', 'bg-blue-50');
                }
            });
        });
    }

    // 2. Logic Highlight saat Checkbox biasa diklik
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const row = this.closest('tr');
            if (this.checked) {
                row.classList.add('selected', 'bg-blue-50');
            } else {
                row.classList.remove('selected', 'bg-blue-50');
            }
        });
    });
    
    // 3. Logic Filter Sederhana (Jika ada input pencarian tabel)
    const tableSearch = document.getElementById('table-search');
    if (tableSearch) {
        tableSearch.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('.datagrid-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    }
}