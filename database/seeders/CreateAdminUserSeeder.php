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
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $viewerUser = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $adminRole = Role::create(['name' => 'Admin']);
        $viewerRole = Role::create(['name' => 'Viewer']);

        $allPermissions = Permission::pluck('id', 'id')->all();

        $adminRole->syncPermissions($allPermissions);

        $viewerPermissionNames = [
            'penjualan-list',
            'detail-penjualan-produk-list',
            'laporan-list',
        ];

        
        $viewerPermissions = Permission::whereIn('name', $viewerPermissionNames)->get();

        $viewerRole->syncPermissions($viewerPermissions);

        $adminUser->assignRole([$adminRole->id]);
        $viewerUser->assignRole($viewerRole);
    }
}