/* =========================================
   FINANCE & CALCULATOR
   ========================================= */
import { formatRupiah } from '../utils/formatters';

export function initFinanceCalculator() {
    const inputBayar = document.getElementById('input-bayar');
    const textTotal = document.getElementById('text-total-tagihan'); // Hidden input atau data attribute
    const textKembalian = document.getElementById('text-kembalian');

    if (inputBayar && textTotal && textKembalian) {
        inputBayar.addEventListener('keyup', function() {
            // Hapus karakter non-angka
            let bayar = parseInt(this.value.replace(/[^0-9]/g, '')) || 0;
            let total = parseInt(textTotal.getAttribute('data-value')) || 0;
            
            // Hitung Kembalian
            let kembalian = bayar - total;
            
            // Tampilkan (Jika minus berarti kurang bayar)
            if (kembalian >= 0) {
                textKembalian.textContent = formatRupiah(kembalian);
                textKembalian.classList.remove('text-danger');
                textKembalian.classList.add('text-success');
            } else {
                textKembalian.textContent = "Kurang: " + formatRupiah(Math.abs(kembalian));
                textKembalian.classList.add('text-danger');
            }
        });
    }
}