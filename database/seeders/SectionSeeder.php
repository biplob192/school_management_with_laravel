<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // High school:
        // daffodil, jasmine, tulip.

        // Primary:
        // cameliya, silvia

        $sections = [
            // ['name' => 'Common', 'is_active' => true],
            ['name' => 'Cameliya', 'is_active' => true],
            ['name' => 'Silvia', 'is_active' => true],
            ['name' => 'Daffodil', 'is_active' => true],
            ['name' => 'Jasmine', 'is_active' => true],
            ['name' => 'Tulip', 'is_active' => true],
        ];

        foreach ($sections as $section) {
            DB::table('sections')->updateOrInsert(
                ['name' => $section['name']], // match condition
                [
                    'is_active'  => $section['is_active'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
