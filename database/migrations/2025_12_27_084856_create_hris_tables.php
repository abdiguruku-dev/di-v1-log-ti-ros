<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL PEGAWAI (Master Data SDM)
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Link ke Akun Login
            
            // Identitas Utama
            $table->string('nip')->unique()->nullable();
            $table->string('nik_ktp')->unique();
            $table->string('nama_lengkap');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            
            // Biodata
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama');
            $table->enum('status_pernikahan', ['menikah', 'belum_menikah', 'janda_duda']);
            
            // Kontak
            $table->string('no_hp');
            $table->string('email_pribadi')->nullable();
            $table->text('alamat_ktp');
            $table->text('alamat_domisili')->nullable();
            
            // Kepegawaian
            $table->string('status_kepegawaian'); // PNS, GTY, GTT, Honorer
            $table->date('tgl_masuk');
            $table->string('npwp')->nullable();
            $table->string('no_bpjs_kesehatan')->nullable();
            $table->string('no_bpjs_ketenagakerjaan')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Agar data tidak hilang permanen saat dihapus
            
            // Foreign Key ke Users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // 2. TABEL KELUARGA (Untuk Tunjangan)
        Schema::create('pegawai_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('nama');
            $table->enum('hubungan', ['suami', 'istri', 'anak']);
            $table->date('tgl_lahir');
            $table->string('pekerjaan')->nullable();
            $table->timestamps();
        });

        // 3. TABEL ARSIP DIGITAL
        Schema::create('pegawai_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('nama_dokumen'); // Misal: SK Pengangkatan, Ijazah S1
            $table->string('jenis_dokumen'); // sk, ijazah, ktp, sertifikat
            $table->string('file_path'); // Lokasi file tersimpan
            $table->timestamps();
        });

        // 4. TABEL RIWAYAT PENDIDIKAN
        Schema::create('pegawai_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('jenjang'); // SD, SMP, SMA, S1, S2
            $table->string('nama_sekolah');
            $table->string('jurusan')->nullable();
            $table->year('tahun_lulus');
            $table->string('file_ijazah')->nullable(); // Bukti scan
            $table->timestamps();
        });
        
        // 5. TABEL PENGAJUAN LAYANAN (Cuti, Dinas, dll)
        Schema::create('pengajuan_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('jenis_layanan'); // cuti_tahunan, cuti_sakit, dinas_luar
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->text('alasan');
            $table->string('dokumen_pendukung')->nullable(); // Surat dokter dll
            $table->enum('status', ['diajukan', 'disetujui_kepsek', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('catatan_approval')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_layanan');
        Schema::dropIfExists('pegawai_pendidikan');
        Schema::dropIfExists('pegawai_dokumen');
        Schema::dropIfExists('pegawai_keluarga');
        Schema::dropIfExists('pegawai');
    }
};