<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Murid extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'murid'; // Pastikan nama tabel benar
    protected $guarded = ['id']; // Membuka semua kolom agar bisa diisi

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    // Relasi ke Wali
    public function wali()
    {
        return $this->hasOne(MuridWali::class, 'murid_id');
    }
}