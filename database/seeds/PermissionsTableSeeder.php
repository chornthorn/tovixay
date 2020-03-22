<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Read Role',      'for' => 'role']);
        Permission::create(['name' => 'Create Role',      'for' => 'role']);
        Permission::create(['name' => 'Update Role',      'for' => 'role']);
        Permission::create(['name' => 'Delete Role',      'for' => 'role']);

        Permission::create(['name' => 'Read User',      'for' => 'user']);
        Permission::create(['name' => 'Create User',      'for' => 'user']);
        Permission::create(['name' => 'Update User',      'for' => 'user']);
        Permission::create(['name' => 'Delete User',      'for' => 'user']);

        Permission::create(['name' => 'Read Category',      'for' => 'category']);
        Permission::create(['name' => 'Create Category',      'for' => 'category']);
        Permission::create(['name' => 'Update Category',      'for' => 'category']);
        Permission::create(['name' => 'Delete Category',      'for' => 'category']);

        Permission::create(['name' => 'Read Brand',      'for' => 'brand']);
        Permission::create(['name' => 'Create Brand',      'for' => 'brand']);
        Permission::create(['name' => 'Update Brand',      'for' => 'brand']);
        Permission::create(['name' => 'Delete Brand',      'for' => 'brand']);

        Permission::create(['name' => 'Read Model',      'for' => 'model']);
        Permission::create(['name' => 'Create Model',      'for' => 'model']);
        Permission::create(['name' => 'Update Model',      'for' => 'model']);
        Permission::create(['name' => 'Delete Model',      'for' => 'model']);

        Permission::create(['name' => 'Read Status',      'for' => 'status']);
        Permission::create(['name' => 'Create Status',      'for' => 'status']);
        Permission::create(['name' => 'Update Status',      'for' => 'status']);
        Permission::create(['name' => 'Delete Status',      'for' => 'status']);

        Permission::create(['name' => 'Read Location',      'for' => 'location']);
        Permission::create(['name' => 'Create Location',      'for' => 'location']);
        Permission::create(['name' => 'Update Location',      'for' => 'location']);
        Permission::create(['name' => 'Delete Location',      'for' => 'location']);

        Permission::create(['name' => 'Read Cost Center',      'for' => 'cost']);
        Permission::create(['name' => 'Create Cost Center',      'for' => 'cost']);
        Permission::create(['name' => 'Update Cost Center',      'for' => 'cost']);
        Permission::create(['name' => 'Delete Cost Center',      'for' => 'cost']);

        Permission::create(['name' => 'Read Report',      'for' => 'report']);
        Permission::create(['name' => 'Create Report',      'for' => 'report']);
        Permission::create(['name' => 'Update Report',      'for' => 'report']);
        Permission::create(['name' => 'Delete Report',      'for' => 'report']);

        Permission::create(['name' => 'Read Asset',      'for' => 'asset']);
        Permission::create(['name' => 'Create Asset',      'for' => 'asset']);
        Permission::create(['name' => 'Update Asset',      'for' => 'asset']);
        Permission::create(['name' => 'Delete Asset',      'for' => 'asset']);

        Permission::create(['name' => 'Read Computer',      'for' => 'computer']);
        Permission::create(['name' => 'Create Computer',      'for' => 'computer']);
        Permission::create(['name' => 'Update Computer',      'for' => 'computer']);
        Permission::create(['name' => 'Delete Computer',      'for' => 'computer']);

        Permission::create(['name' => 'Print Asset',      'for' => 'print']);
        Permission::create(['name' => 'Print Report',      'for' => 'print']);
        Permission::create(['name' => 'Print Computer',      'for' => 'print']);
        Permission::create(['name' => 'Print History',      'for' => 'print']);
    }
}
