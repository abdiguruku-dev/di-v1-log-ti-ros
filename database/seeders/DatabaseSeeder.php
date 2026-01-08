<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Login (Biar Bos bisa login)
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password'), // Password default
        ]);

        // 2. Buat Data Kelas (Rombel)
        $kelas1 = Kelas::create(['nama_kelas' => 'X RPL 1', 'tingkat' => '10', 'jurusan' => 'RPL']);
        $kelas2 = Kelas::create(['nama_kelas' => 'XI TKJ 1', 'tingkat' => '11', 'jurusan' => 'TKJ']);
        $kelas3 = Kelas::create(['nama_kelas' => 'XII AK 2', 'tingkat' => '12', 'jurusan' => 'Akuntansi']);

        $listKelasId = [$kelas1->id, $kelas2->id, $kelas3->id];

        // 3. Buat 50 Data Murid Palsu
        Murid::factory(50)->create()->each(function ($murid) use ($listKelasId) {
            
            // Update Kelas secara acak
            $murid->update([
                'kelas_id' => $listKelasId[array_rand($listKelasId)]
            ]);

            // (Opsional) Buat Data Wali Palsu untuk setiap murid
            \App\Models\MuridWali::create([
                'murid_id' => $murid->id,
                'hubungan' => 'ayah',
                'nama_wali' => 'Bapaknya ' . explode(' ', $murid->nama_lengkap)[0], // Nama bapaknya ngasal
                'no_hp_wali' => '0812' . rand(10000000, 99999999),
                'pekerjaan' => 'Wiraswasta',
            ]);
        });
    }
}