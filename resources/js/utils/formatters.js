/* =========================================
   FORMATTER UTILITIES
   ========================================= */

// Format Angka ke Rupiah: formatRupiah(50000) -> "Rp 50.000"
export function formatRupiah(angka, prefix = 'Rp ') {
    if (!angka) return '';
    let number_string = angka.toString().replace(/[^,\d]/g, '').toString();
    let split = number_string.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix + rupiah;
}

// Format Tanggal Indo: formatDate('2023-12-25') -> "25 Desember 2023"
export function formatDateIndo(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}