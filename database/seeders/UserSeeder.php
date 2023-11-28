<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $ketua = User::create([
            'name' => 'ketua',
            'email' => 'ketua@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $ketua->assignRole('ketua');

        $bendahara = User::create([
            'name' => 'bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $bendahara->assignRole('bendahara');

        $anggota = User::create([
            'name' => 'anggota',
            'email' => 'anggota@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $anggota->assignRole('anggota');
    }
}
