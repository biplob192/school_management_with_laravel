<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'Nursery', 'numeric_value' => 0, 'is_active' => true],
            ['name' => 'KG',      'numeric_value' => 0, 'is_active' => true],
            ['name' => 'One',     'numeric_value' => 1, 'is_active' => true],
            ['name' => 'Two',     'numeric_value' => 2, 'is_active' => true],
            ['name' => 'Three',   'numeric_value' => 3, 'is_active' => true],
            ['name' => 'Four',    'numeric_value' => 4, 'is_active' => true],
            ['name' => 'Five',    'numeric_value' => 5, 'is_active' => true],
            ['name' => 'Six',     'numeric_value' => 6, 'is_active' => true],
            ['name' => 'Seven',   'numeric_value' => 7, 'is_active' => true],
            ['name' => 'Eight',   'numeric_value' => 8, 'is_active' => true],
            ['name' => 'Nine',    'numeric_value' => 9, 'is_active' => true],
            ['name' => 'Ten',     'numeric_value' => 10, 'is_active' => true],
            ['name' => 'Eleven',  'numeric_value' => 11, 'is_active' => true],
            ['name' => 'Twelve',  'numeric_value' => 12, 'is_active' => true],
        ];

        // foreach ($classes as $class) {
        //     DB::table('classes')->updateOrInsert(
        //         ['name' => $class['name']], // match condition
        //         [
        //             'numeric_value' => $class['numeric_value'],
        //             'is_active'     => $class['is_active'],
        //             'updated_at'    => now(),
        //             'created_at'    => now(),
        //         ]
        //     );
        // }


        // New code
        $groupIds = DB::table('groups')->whereIn('name', ['Science', 'Arts', 'Commerce'])->pluck('id', 'name');
        $sectionIds = DB::table('sections')->pluck('id', 'name');

        foreach ($classes as $class) {
            DB::table('classes')->updateOrInsert(
                ['name' => $class['name']], // match condition
                [
                    'numeric_value' => $class['numeric_value'],
                    'is_active'     => $class['is_active'],
                    'updated_at'    => now(),
                    'created_at'    => now(),
                ]
            );

            // Get class record ID
            $classRecord = DB::table('classes')->where('name', $class['name'])->first();

            if (in_array($class['name'], ['Nine', 'Ten', 'Eleven', 'Twelve'])) {
                foreach ($groupIds as $groupId) {
                    DB::table('class_groups')->updateOrInsert(
                        ['class_id' => $classRecord->id, 'group_id' => $groupId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            if (in_array($class['name'], ['Six', 'Seven', 'Eight', 'Nine', 'Ten'])) {
                foreach (['Daffodil', 'Jasmine', 'Tulip'] as $section) {
                    $sectionId = $sectionIds[$section] ?? null;
                    if ($sectionId) {
                        DB::table('class_sections')->updateOrInsert(
                            ['class_id' => $classRecord->id, 'section_id' => $sectionId],
                            ['created_at' => now(), 'updated_at' => now()]
                        );
                    }
                }
            }

            if (in_array($class['name'], ['Nursery', 'KG', 'One', 'Two', 'Three', 'Four', 'Five'])) {
                foreach (['Cameliya', 'Silvia'] as $section) {
                    $sectionId = $sectionIds[$section] ?? null;
                    if ($sectionId) {
                        DB::table('class_sections')->updateOrInsert(
                            ['class_id' => $classRecord->id, 'section_id' => $sectionId],
                            ['created_at' => now(), 'updated_at' => now()]
                        );
                    }
                }
            }
        }
    }
}
