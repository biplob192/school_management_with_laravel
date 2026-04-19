<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $subjects = [
        //     // Nursery & KG
        //     'Pre-writing Skills',
        //     'Alphabet (Bangla)',
        //     'Alphabet (English)',
        //     'Basic Numbers',
        //     'Rhymes and Songs',
        //     'Storytelling',
        //     'Drawing and Coloring',
        //     'Health and Hygiene',
        //     'Good Manners and Behavior',
        //     'Physical Play and Activities',

        //     // Primary (Class 1–5)
        //     'Bangla',
        //     'English',
        //     'Mathematics',
        //     'Science',
        //     'Bangladesh and Global Studies',
        //     'Religion and Moral Education',
        //     'Information and Communication Technology',
        //     'Arts and Crafts',
        //     'Physical Education and Health',

        //     // Secondary (Class 6–10)
        //     'Agricultural Studies',
        //     'Home Science',
        //     'Career Education',
        //     'Work and Life Oriented Education',
        //     'Islam and Moral Education',
        //     'Hindu Religion and Moral Education',
        //     'Buddhist Religion and Moral Education',
        //     'Christian Religion and Moral Education',

        //     // Higher Secondary (Class 11–12)
        //     'Physics',
        //     'Chemistry',
        //     'Biology',
        //     'Higher Mathematics',
        //     'Accounting',
        //     'Business Studies',
        //     'Economics',
        //     'Civics and Good Governance',
        //     'Geography and Environment',
        //     'History',
        //     'Logic',
        //     'Sociology',
        //     'Psychology',
        //     'Statistics',
        //     'Islamic History and Culture',
        //     'Computer Science and Applications',
        //     'Finance, Banking and Insurance',
        //     'Production Management and Marketing',
        //     'Entrepreneurship Development',
        // ];


        // foreach ($subjects as $subject) {
        //     DB::table('subjects')->updateOrInsert(
        //         ['name' => $subject],
        //         [
        //             'is_active'  => true,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]
        //     );
        // }



        $subjects = ['Bangla', 'English', 'Math'];

        $targetClasses = DB::table('classes')
            ->whereIn('numeric_value', [6, 7, 8])
            ->pluck('id', 'numeric_value');

        foreach ($targetClasses as $numeric => $classId) {
            foreach ($subjects as $subject) {
                DB::table('subjects')->updateOrInsert(
                    [
                        'name' => $subject,
                        'class_id' => $classId,
                        'section_id' => null, // Common to all sections
                    ],
                    [
                        'code' => null,
                        'is_common_group' => false,
                        'group_id' => null,
                        'is_common_section' => true,
                        'written_mark' => 50,
                        'written_pass_mark' => 0,
                        'mcq_mark' => 50,
                        'mcq_pass_mark' => 0,
                        'practical_mark' => 0,
                        'practical_pass_mark' => 0,
                        'viva_mark' => 0,
                        'viva_pass_mark' => 0,
                        'assessment_mark' => 0,
                        'assessment_pass_mark' => 0,
                        'other_mark' => 0,
                        'total_mark' => 100,
                        'pass_mark' => 33,
                        'pass_mark_percent' => 33,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
