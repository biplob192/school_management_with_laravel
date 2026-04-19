<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            'Principal',
            'Vice Principal',
            'Lecturar',
            'Assistant Teacher',
        ];

        foreach ($designations as $name) {
            DB::table('designations')->updateOrInsert(
                ['name' => $name],
                [
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
