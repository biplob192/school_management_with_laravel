<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get class IDs for class numeric_value 9 to 12
        $classIds = DB::table('classes')
            ->whereIn('numeric_value', [9, 10, 11, 12])
            ->pluck('id', 'numeric_value'); // key by numeric_value for clarity

        // Get group IDs by name
        $groupIds = DB::table('groups')
            ->whereIn('name', ['Science', 'Arts', 'Commerce'])
            ->pluck('id', 'name'); // key by name for clarity

        // Loop through each relevant class and assign all groups
        foreach ($classIds as $numeric => $classId) {
            foreach ($groupIds as $groupName => $groupId) {
                DB::table('class_groups')->updateOrInsert(
                    [
                        'class_id' => $classId,
                        'group_id' => $groupId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
