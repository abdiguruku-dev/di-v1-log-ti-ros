<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    // A. HUBUNGKAN KE TABEL YANG BENAR
    protected $table = 'pegawai';

    // B. BUKA GREDEL (MASS ASSIGNMENT)
    // $guarded = [] artinya: "Tidak ada kolom yang dilindungi, silakan isi semua".
    // Ini solusi paling cepat & aman selama kita yang kontrol inputnya.
    protected $guarded = [];

    // C. RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}