<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Get the teacher from the teacher table (only one created in UserSeeder)
        // $teacher = Teacher::first();
        // if (!$teacher) return;

        // // Get all section IDs
        // $sections = Section::pluck('id')->toArray();

        // // Get subjects named 'English' for class 6, 7, 8
        // $classIds = SchoolClass::whereIn('numeric_value', ['6', '7', '8'])->pluck('id')->toArray();
        // $englishSubjects = Subject::where('name', 'English')
        //     ->whereIn('class_id', $classIds)
        //     ->get();

        // $data = [];

        // foreach ($englishSubjects as $subject) {
        //     foreach ($sections as $sectionId) {
        //         $data[] = [
        //             'subject_id' => $subject->id,
        //             'group_id'   => null,
        //             'section_id' => $sectionId,
        //             'teacher_id' => $teacher->id,
        //             'shift'      => 'Morning',
        //             'role'       => 'Subject Teacher',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ];
        //     }
        // }

        // foreach (array_chunk($data, 100) as $chunk) {
        //     DB::table('subject_teachers')->insert($chunk);
        // }



        // Get the teacher from the teacher table (only one created in UserSeeder)
        $teacher = Teacher::first();
        if (!$teacher) return;

        // Get subjects named 'English' for class 6, 7, 8
        $classIds = SchoolClass::whereIn('numeric_value', ['6', '7', '8'])->pluck('id')->toArray();

        // Get all section IDs
        $sectionIds = DB::table('class_sections')->where('class_id', $classIds)->pluck('id')->toArray();

        $englishSubjects = Subject::where('name', 'English')
            ->whereIn('class_id', $classIds)
            ->get();

        $data = [];

        foreach ($englishSubjects as $subject) {
            if ($subject->is_common_section) {
                // Common subject: assign once without section
                DB::table('subject_teachers')->updateOrInsert(
                    [
                        'subject_id'                => $subject->id,
                        'teacher_id'                => $teacher->id,
                        'shift'                     => 'Morning',
                        'is_common_section_teacher' => true,
                    ],
                    [
                        'section_id' => null,
                        'group_id'   => null,
                        'role'       => 'Subject Teacher',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } else {
                // Not common: assign teacher to each section
                foreach ($sectionIds as $sectionId) {
                    DB::table('subject_teachers')->updateOrInsert(
                        [
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher->id,
                            'shift'      => 'Morning',
                            'section_id' => $sectionId,
                        ],
                        [
                            'group_id'                  => $subject->group_id,
                            'role'                      => 'Subject Teacher',
                            'is_common_section_teacher' => false,
                            'created_at'                => now(),
                            'updated_at'                => now(),
                        ]
                    );
                }
            }
        }

        foreach (array_chunk($data, 100) as $chunk) {
            DB::table('subject_teachers')->insert($chunk);
        }
    }
}
