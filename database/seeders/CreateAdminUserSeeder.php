<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $user2 = User::create([
            'name' => 'Viewer', 
            'email' => 'viewer@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        
        $role = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Viewer']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
        $role2->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
        $user2->assignRole([$role2->id]);
    }
}
