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
            'password' => bcrypt('12345678')
        ]);

        $admin->assignRole('admin');

        $landlord = User::firstOrCreate([
            'email' => 'landlord@gmail.com'
        ], [
            'name' => 'Landlord',
            'password' => bcrypt('12345678')
        ]);

        $landlord->assignRole('landlord');

        $tenant = User::firstOrCreate([
            'email' => 'tenant@gmail.com'
        ], [
            'name' => 'Tenant',
            'password' => bcrypt('12345678')
        ]);

        $tenant->assignRole('tenant');

        // Thêm nhiều landlord (chủ trọ)
        $landlords = [
            [
                'name' => 'Nguyễn Văn Minh',
                'email' => 'minhnv@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Trần Thị Hoa',
                'email' => 'hoatt@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Lê Quang Dũng',
                'email' => 'dunglq@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Phạm Thị Mai',
                'email' => 'maipt@gmail.com',
                'password' => bcrypt('12345678')
            ]
        ];

        foreach ($landlords as $landlordData) {
            $newLandlord = User::firstOrCreate([
                'email' => $landlordData['email']
            ], $landlordData);
            $newLandlord->assignRole('landlord');
        }

        // Thêm nhiều tenant (người thuê)
        $tenants = [
            [
                'name' => 'Võ Thị Lan',
                'email' => 'lanvt@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Hoàng Văn Tú',
                'email' => 'tuhv@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Đặng Thị Nga',
                'email' => 'ngadt@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Bùi Văn Khang',
                'email' => 'khangbv@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Lý Thị Thanh',
                'email' => 'thanhlt@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Phan Văn Đức',
                'email' => 'ducpv@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Ngô Thị Hương',
                'email' => 'huongnt@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Vũ Văn Long',
                'email' => 'longvv@gmail.com',
                'password' => bcrypt('12345678')
            ]
        ];

        foreach ($tenants as $tenantData) {
            $newTenant = User::firstOrCreate([
                'email' => $tenantData['email']
            ], $tenantData);
            $newTenant->assignRole('tenant');
        }

        // Thêm admin phụ
        $adminAssistants = [
            [
                'name' => 'Quản trị viên 2',
                'email' => 'admin2@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'Support Admin',
                'email' => 'support@gmail.com',
                'password' => bcrypt('12345678')
            ]
        ];

        foreach ($adminAssistants as $adminData) {
            $newAdmin = User::firstOrCreate([
                'email' => $adminData['email']
            ], $adminData);
            $newAdmin->assignRole('admin');
        }
    }
}
