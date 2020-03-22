<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administration',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::find('1');

        $permissions = Permission::all();

        $role->permissions()->sync($permissions);

        $user = User::find(1);

        $user->roles()->sync($role);

        //

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $role = Role::find('2');

        $permissions = Permission::find([5,6,7,8]);

        $role->permissions()->sync($permissions);

        $user = User::find(2);

        $user->roles()->sync($role);
    }
}
