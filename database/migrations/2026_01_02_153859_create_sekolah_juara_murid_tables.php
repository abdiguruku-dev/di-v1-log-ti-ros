<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. TABEL KELAS (ROMBEL)
        // Kita butuh ini dulu sebelum membuat data murid
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // Contoh: X RPL 1, XII TKJ 2
            $table->string('tingkat');    // Contoh: 10, 11, 12
            $table->string('jurusan')->nullable(); // Contoh: Rekayasa Perangkat Lunak
            // Nanti bisa direlasikan dengan tabel pegawai (wali kelas)
            // $table->foreignId('wali_kelas_id')->nullable()->constrained('pegawai'); 
            $table->timestamps();
            $table->softDeletes(); // Agar data tidak hilang permanen
        });

        // 2. TABEL MURID (MASTER DATA)
        Schema::create('murid', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User Login (Bisa Null dulu jika murid belum punya akun)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Relasi ke Kelas
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');

            // Identitas Utama
            $table->string('nis')->unique()->nullable();  // Nomor Induk Sekolah
            $table->string('nisn')->unique()->nullable(); // Nomor Induk Siswa Nasional
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            
            // Kontak & Alamat
            $table->string('no_hp_siswa')->nullable();
            $table->string('email_siswa')->nullable();
            $table->text('alamat_jalan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();

            // Atribut Sistem
            $table->string('foto_profil')->nullable(); // Path foto
            // Status: aktif (Hijau), lulus (Biru), mutasi/keluar (Merah)
            $table->enum('status', ['aktif', 'lulus', 'mutasi', 'keluar', 'meninggal'])->default('aktif');
            $table->date('tanggal_masuk')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Fitur penting untuk audit data
        });

        // 3. TABEL WALI MURID (Orang Tua)
        // Dipisah agar 1 murid bisa punya data Ayah, Ibu, dan Wali sekaligus
        Schema::create('murid_wali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            
            $table->enum('hubungan', ['ayah', 'ibu', 'wali']); // Sebagai apa?
            $table->string('nama_wali');
            $table->string('nik')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('penghasilan_bulanan')->nullable();
            $table->string('no_hp_wali')->nullable(); // PENTING: Untuk fitur WhatsApp Gateway
            $table->text('alamat_wali')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murid_wali');
        Schema::dropIfExists('murid');
        Schema::dropIfExists('kelas');
    }
};