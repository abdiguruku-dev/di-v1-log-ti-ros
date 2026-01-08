<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset Cache Permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Permission
        $permissions = [
            'view-dashboard',
            'manage-users',
            'manage-kelas',
            'manage-mapel',
            'input-nilai',
            'view-rapor',
            'manage-spp',
            'terima-pembayaran',
            'view-laporan-keuangan',
            'manage-surat',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Roles
        $roleAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleGuru = Role::firstOrCreate(['name' => 'guru']);
        $roleGuru->givePermissionTo(['view-dashboard', 'input-nilai', 'view-rapor']);

        $roleStaff = Role::firstOrCreate(['name' => 'staff-tu']);
        $roleStaff->givePermissionTo(['view-dashboard', 'manage-users', 'manage-surat']);

        $roleBendahara = Role::firstOrCreate(['name' => 'bendahara']);
        $roleBendahara->givePermissionTo(['view-dashboard', 'manage-spp', 'terima-pembayaran', 'view-laporan-keuangan']);

        $roleMurid = Role::firstOrCreate(['name' => 'murid']);
        $roleMurid->givePermissionTo(['view-rapor']);

        // ==========================================================
        // 4. BUAT USER & PEGAWAI (LENGKAP SESUAI LOG DATABASE BOS)
        // ==========================================================

        // --- A. SUPER ADMIN ---
        DB::transaction(function () use ($roleAdmin) {
            $user = User::create([
                'name' => 'Administrator',
                'email' => 'admin@sekolah.com',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]);
            $user->assignRole($roleAdmin);

            Pegawai::create([
                'user_id' => $user->id,
                'nip'     => '19900101', // Login pakai ini
                'nik_ktp' => '3171010101900001',
                'nama_lengkap' => 'Budi Santoso',
                'gelar_depan' => 'H.',
                'gelar_belakang' => 'S.Kom, M.T.',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'status_pernikahan' => 'menikah',
                'no_hp' => '08129999999', // Login pakai ini
                'email_pribadi' => 'budi.admin@gmail.com',
                'alamat_ktp' => 'Jl. Merdeka No. 1, Jakarta',
                'alamat_domisili' => 'Jl. Merdeka No. 1, Jakarta',
                'status_kepegawaian' => 'Tetap',
                'tgl_masuk' => '2020-01-01',
            ]);
        });

        // --- B. GURU (Bu Ani) ---
        DB::transaction(function () use ($roleGuru) {
            $user = User::create([
                'name' => 'Ani Lestari',
                'email' => 'guru@sekolah.com',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]);
            $user->assignRole($roleGuru);

            Pegawai::create([
                'user_id' => $user->id,
                'nip'     => '20230505', // Login pakai ini
                'nik_ktp' => '3201010505950002',
                'nama_lengkap' => 'Ani Lestari',
                'gelar_depan' => '',
                'gelar_belakang' => 'S.Pd.',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1995-05-05',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'status_pernikahan' => 'belum_menikah',
                'no_hp' => '08228888888', // Login pakai ini
                'email_pribadi' => 'ani.guru@gmail.com',
                'alamat_ktp' => 'Jl. Pendidikan No. 10, Bandung',
                'alamat_domisili' => 'Jl. Pendidikan No. 10, Bandung',
                'status_kepegawaian' => 'Tetap',
                'tgl_masuk' => '2023-01-01',
            ]);
        });

        // --- C. STAFF TU (Pak Anto - Case Fleksibel) ---
        DB::transaction(function () use ($roleStaff) {
            $user = User::create([
                'name' => 'Anto Wijaya',
                'email' => 'anto@sekolah.com',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]);
            $user->assignRole($roleStaff);
            $user->givePermissionTo('terima-pembayaran'); // Spesial Permission

            Pegawai::create([
                'user_id' => $user->id,
                'nip'     => '20230909',
                'nik_ktp' => '3301010909920003',
                'nama_lengkap' => 'Anto Wijaya',
                'gelar_depan' => '',
                'gelar_belakang' => 'A.Md.',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1992-09-09',
                'jenis_kelamin' => 'L',
                'agama' => 'Kristen',
                'status_pernikahan' => 'menikah',
                'no_hp' => '08337777777',
                'email_pribadi' => 'anto.tu@gmail.com',
                'alamat_ktp' => 'Jl. Administrasi No. 5',
                'alamat_domisili' => 'Jl. Administrasi No. 5',
                'status_kepegawaian' => 'Kontrak',
                'tgl_masuk' => '2023-06-01',
            ]);
        });
    }
}