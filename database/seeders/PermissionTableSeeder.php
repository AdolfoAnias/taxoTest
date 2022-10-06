<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {           
        $this->createPermissions();
        $this->createRolesAndAssignPermissions();
        
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
    
    public function createPermissions()
    {
        Permission::create(['name' => 'view_management_user', 'parent_id' => 0]);
        Permission::create(['name' => 'view_mails', 'parent_id' => 0]);
        Permission::create(['name' => 'create_mail', 'parent_id' => 0]);
        Permission::create(['name' => 'import_excel_mail', 'parent_id' => 0]);
        Permission::create(['name' => 'export_excel_mail', 'parent_id' => 0]);
        Permission::create(['name' => 'update_mail', 'parent_id' => 0]);
        Permission::create(['name' => 'delete_mail', 'parent_id' => 0]);                
    }        
    
    public function createRolesAndAssignPermissions()
    {
        $roleAdmin = Role::create(['name' => 'Admin','description' => 'This is the administration role']);
        $roleUser = Role::create(['name' => 'User','description' => 'This is the creator role']);        

        $roleAdmin->givePermissionTo(Permission::all());        
        $roleUser->givePermissionTo('view_mails');        
    }        
    
}
