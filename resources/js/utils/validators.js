/* =========================================
   VALIDATION HELPERS
   ========================================= */

export const validators = {
    // Cek apakah input hanya angka (untuk NISN/No HP)
    isNumeric: (value) => /^\d+$/.test(value),
    
    // Cek format email dasar
    isEmail: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
    
    // Cek panjang minimal (misal Password min 8)
    minLength: (value, min) => value.length >= min,

    // Cek Range Nilai (0 - 100)
    isValidGrade: (value) => value >= 0 && value <= 100
};