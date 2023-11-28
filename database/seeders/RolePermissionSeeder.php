<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create permission
        Permission::create(['name' => 'view data_simpanan']);
        Permission::create(['name' => 'create data_simpanan']);
        Permission::create(['name' => 'view data_pinjaman']);
        Permission::create(['name' => 'create data_pinjaman']);
        Permission::create(['name' => 'view data_angsuran']);
        Permission::create(['name' => 'create data_angsuran']);

        //create role and assign existing permission
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'ketua']);
        Role::create(['name' => 'bendahara']);
        Role::create(['name' => 'anggota']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('view data_simpanan');
        $roleAdmin->givePermissionTo('create data_simpanan');
        $roleAdmin->givePermissionTo('view data_pinjaman');
        $roleAdmin->givePermissionTo('create data_pinjaman');
        $roleAdmin->givePermissionTo('view data_angsuran');
        $roleAdmin->givePermissionTo('create data_angsuran');

        $roleAnggota = Role::findByName('ketua');
        $roleAnggota->givePermissionTo('view data_simpanan');
        $roleAnggota->givePermissionTo('create data_simpanan');
        $roleAnggota->givePermissionTo('view data_pinjaman');
        $roleAnggota->givePermissionTo('create data_pinjaman');
        $roleAnggota->givePermissionTo('view data_angsuran');
        $roleAnggota->givePermissionTo('create data_angsuran');

        $roleAnggota = Role::findByName('bendahara');
        $roleAnggota->givePermissionTo('view data_simpanan');
        $roleAnggota->givePermissionTo('create data_simpanan');
        $roleAnggota->givePermissionTo('view data_pinjaman');
        $roleAnggota->givePermissionTo('create data_pinjaman');
        $roleAnggota->givePermissionTo('view data_angsuran');
        $roleAnggota->givePermissionTo('create data_angsuran');

        $roleAnggota = Role::findByName('anggota');
        $roleAnggota->givePermissionTo('view data_simpanan');
        $roleAnggota->givePermissionTo('create data_simpanan');
        $roleAnggota->givePermissionTo('view data_pinjaman');
        $roleAnggota->givePermissionTo('create data_pinjaman');
        $roleAnggota->givePermissionTo('view data_angsuran');
        $roleAnggota->givePermissionTo('create data_angsuran');
    }
}
