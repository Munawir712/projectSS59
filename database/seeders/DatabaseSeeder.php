<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Facility;
use App\Models\Kosan;
use App\Models\Penyewa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'roles' => 'ADMIN',
            'phone_number' => '081234567891',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        Penyewa::create([
            'user_id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '081234567891',
            'jenis_kelamin' => 'pria'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'usertest',
            'email' => 'usertest@gmail.com',
            'phone_number' => '089876543210',
            'jenis_kelamin' => 'pria',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        Penyewa::create([
            'user_id' => 2,
            'name' => 'usertest',
            'email' => 'usertest@gmail.com',
            'phone_number' => '089876543210',
            'jenis_kelamin' => 'pria'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'usertest2',
            'email' => 'usertest2@gmail.com',
            'phone_number' => '089876543211',
            'jenis_kelamin' => 'wanita',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        Facility::create([
            'name' => 'TV',
            'slug' => 'tv',
            'desc' => 'Televisi',
        ]);
        Facility::create([
            'name' => 'Wifi',
            'slug' => 'wifi',
            'desc' => 'Internet untuk penghuni',
        ]);
        Facility::create([
            'name' => 'Meja',
            'slug' => 'meja',
            'desc' => '1 Meja',
        ]);
        Facility::create([
            'name' => 'Kursi',
            'slug' => 'kursi',
            'desc' => '1 kursi',
        ]);
        Facility::create([
            'name' => 'Kamar Mandi',
            'slug' => 'kamar_mandi',
            'desc' => 'Memiliki Kamar Mandi',
        ]);
        Facility::create([
            'name' => 'AC',
            'slug' => 'ac',
            'desc' => 'Air Container',
        ]);
        Facility::create([
            'name' => 'Kipas Angin',
            'slug' => 'kipas_angin',
            'desc' => 'Kipas Angin 1 unit',
        ]);
        Facility::create([
            'name' => 'Lemari',
            'slug' => 'lemari',
            'desc' => 'Lemari 4x5',
        ]);
        Facility::create([
            'name' => 'Single Bed',
            'slug' => 'single_bed',
            'desc' => 'Tempat tidur sendiri',
        ]);
        Facility::create([
            'name' => 'Double Bed',
            'slug' => 'double_bed',
            'desc' => 'Tempat tidur berdua',
        ]);

        // Kosan::create([
        //     'no_kamar' => 'KM-1',
        //     'name' => 'Kamar Santai Sedep',
        //     'alamat' => 'Lambhuk, Kota Banda Aceh, Aceh',
        //     'jenis' => 'minimalis',
        //     'tipe' => 'KAMAR',
        //     'kategori_jk' => 'CAMPURAN',
        //     'harga' => 300000,
        // ]);

        // Kosan::create([
        //     'no_kamar' => 'KM-2',
        //     'name' => 'Meneduh saja',
        //     'alamat' => 'Lambhuk, Kota Banda Aceh, Aceh',
        //     'jenis' => 'standar',
        //     'tipe' => 'KAMAR',
        //     'kategori_jk' => 'WANITA',
        //     'harga' => 500000,
        // ]);
    }
}
