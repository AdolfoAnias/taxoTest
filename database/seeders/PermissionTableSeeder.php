<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Permission::create(['name' => 'view_management_user', 'parent_id' => 0]);
        Permission::create(['name' => 'view_mails', 'parent_id' => 0]);
        
        $roleAdmin = Role::create(['name' => 'Admin','description' => 'This is the administration role']);
        $roleUser = Role::create(['name' => 'User','description' => 'This is the creator role']);

        $roleAdmin->givePermissionTo(Permission::all());
        
        $roleUser->givePermissionTo('view_mails');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@taxo.com',
            'role_id' => 1,
            'birth_date' => '1980-02-22',
            'card_id' => '74122207346',
            'city_id' => 1,
            'password' => bcrypt('secret')
        ]);        
        
        $user->assignRole('Admin');
        
    }
}
