<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['name' => 'Nghệ An', 'code' => null],
            ['name' => 'Hà Nội', 'code' => null],
        ];

        foreach ($provinces as $province) {
            if(!DB::table('provinces')
            ->where('name', $province['name'])
            ->where('code', $province['code'])
            ->exists()) {
                DB::table('provinces')->insert($province);
            };
        }
    }
}
