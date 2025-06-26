<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'kategori-list',
            'kategori-create',
            'kategori-edit',
            'kategori-delete',
            'penjualan-list',
            'penjualan-create',
            'penjualan-edit',
            'penjualan-delete',
            'detail-penjualan-produk-list',
            'detail-penjualan-produk-create',
            'detail-penjualan-produk-edit',
            'detail-penjualan-produk-delete',
            'laporan-list',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}