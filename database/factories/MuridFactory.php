<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Murid>
 */
class MuridFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pakai Faker bahasa Indonesia biar namanya lokal (Budi, Siti, dll)
        $faker = \Faker\Factory::create('id_ID');

        return [
            // Generate NIS random: 2023 + 4 digit angka
            'nis' => '2023' . $this->faker->unique()->numerify('####'),
            'nisn' => $this->faker->unique()->numerify('00########'),
            
            'nama_lengkap' => $faker->name(),
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'tempat_lahir' => $faker->city(),
            'tanggal_lahir' => $faker->date('Y-m-d', '2008-01-01'), // Umur anak SMA
            'agama' => 'Islam',
            
            // Alamat lengkap
            'alamat_jalan' => $faker->streetAddress(),
            'desa_kelurahan' => $faker->streetName(),
            'kecamatan' => $faker->city(),
            'kabupaten_kota' => $faker->city(),
            'provinsi' => $faker->state(),
            
            // Status: Kita buat 80% Aktif, sisanya random
            'status' => $faker->randomElement(['aktif', 'aktif', 'aktif', 'aktif', 'lulus', 'mutasi']),
            
            // Foto Profil: Kita kosongkan dulu (Nanti di View kita pakai UI Avatars)
            'foto_profil' => null, 
            
            'tanggal_masuk' => '2023-07-15',
        ];
    }
}