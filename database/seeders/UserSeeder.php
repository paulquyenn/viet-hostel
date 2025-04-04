<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole('admin');

        $landlord = User::firstOrCreate([
            'email' => 'landlord@gmail.com'
        ], [
            'name' => 'Landlord',
            'password' => bcrypt('password')
        ]);

        $landlord->assignRole('landlord');

        $tenant = User::firstOrCreate([
            'email' => 'tenant@gmail.com'
        ], [
            'name' => 'Tenant',
            'password' => bcrypt('password')
        ]);

        $tenant->assignRole('tenant');
    }
}
