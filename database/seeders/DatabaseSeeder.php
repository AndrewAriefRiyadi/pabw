<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'dummy',
            'username' => 'dummy',
            'email' => 'dummy@gmail.com',
            'alamat' => 'dummy alamat',
            'no_hp' => '123456789',
            'password' => Hash::make('123'),
            'saldo' => 2000
        ]);

        User::create([
            'name' => 'tes',
            'username' => 'tes',
            'email' => 'tes@gmail.com',
            'alamat' => 'tes alamat',
            'no_hp' => '123456789',
            'password' => Hash::make('123'),
            'saldo' => 2000
        ]);

        Produk::create([
            'id_user' => 2,
            'nama' => 'barang_tes',
            'harga'=> 1000,
            'deskripsi' => 'tes barang',
            'stok' => 5,
            'foto' => 'foto',
            'status_stok' => 1,
        ]);
    }
}
