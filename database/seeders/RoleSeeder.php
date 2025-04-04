<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard_name = config('auth.defaults.guard');

        // Danh sách vai trò cần kiểm tra và thêm
        $roles = [
            ['name' => 'admin', 'guard_name' => $guard_name],
            ['name' => 'landlord', 'guard_name' => $guard_name],
            ['name' => 'tenant', 'guard_name' => $guard_name],
        ];

        // Kiểm tra và thêm từng vai trò nếu chưa tồn tại
        foreach ($roles as $role) {
            if (!DB::table('roles')->where('name', $role['name'])->exists()) {
                DB::table('roles')->insert($role);
            }
        }
    }
}
