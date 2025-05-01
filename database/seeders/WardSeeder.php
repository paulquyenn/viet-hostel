<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = [
            ['name' => 'Phường Bến Thủy', 'code' => null, 'district_id' => 1],
            ['name' => 'Xã Nghi Phong', 'code' => null, 'district_id' => 1],
            ['name' => 'Phường Trung Đô', 'code' => null, 'district_id' => 1],
        ];

        foreach ($wards as $ward) {
            if(!DB::table('wards')
                ->where('name', $ward['name'])
                ->where('code', $ward['code'])
                ->exists()) {
                DB::table('wards')->insert($ward);
            }
        }
    }
}
