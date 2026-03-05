<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Permissions ──────────────────────────────────────────
        Permission::create(['name' => 'create-product']);
        Permission::create(['name' => 'edit-product']);
        Permission::create(['name' => 'delete-product']);
        Permission::create(['name' => 'manage-brand']);
        Permission::create(['name' => 'manage-user']);

        // ── Roles ─────────────────────────────────────────────────
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $customer = Role::create(['name' => 'customer']);
        // Customer has no admin permissions — only purchase access

        // ── Admin User ────────────────────────────────────────────
        $adminUser = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole('admin');

        // ── Customer User ─────────────────────────────────────────
        $customerUser = User::create([
            'name'     => 'Customer User',
            'email'    => 'customer@example.com',
            'password' => Hash::make('password'),
        ]);
        $customerUser->assignRole('customer');

        // ── Brands ────────────────────────────────────────────────
        $samsung = Brand::create(['name' => 'Samsung',  'is_active' => true]);
        $apple   = Brand::create(['name' => 'Apple',    'is_active' => true]);
        $sony    = Brand::create(['name' => 'Sony',     'is_active' => true]);

        // ── Products (appended under brands) ─────────────────────
        Product::create(['brand_id' => $samsung->id, 'name' => 'Galaxy S24',     'price' => 85000, 'stock' => 10]);
        Product::create(['brand_id' => $samsung->id, 'name' => 'Galaxy Tab S9',  'price' => 65000, 'stock' => 5]);
        Product::create(['brand_id' => $apple->id,   'name' => 'iPhone 16 Pro',  'price' => 145000,'stock' => 8]);
        Product::create(['brand_id' => $apple->id,   'name' => 'MacBook Air M3', 'price' => 175000,'stock' => 3]);
        Product::create(['brand_id' => $sony->id,    'name' => 'WH-1000XM5',     'price' => 35000, 'stock' => 15]);
    }
}
