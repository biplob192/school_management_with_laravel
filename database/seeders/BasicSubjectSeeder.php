<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BasicSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // Primary (Class 1–5)
            'Bangla',
            'English',
            'Mathematics',
            'Science',
            'Bangladesh and Global Studies',
            'Religion and Moral Education',
            'Information and Communication Technology',
            'Arts and Crafts',
            'Physical Education and Health',

            // Secondary (Class 6–10)
            'Agricultural Studies',
            'Home Science',
            'Career Education',
            'Work and Life Oriented Education',
            'Islam and Moral Education',
            'Hindu Religion and Moral Education',
            'Buddhist Religion and Moral Education',
            'Christian Religion and Moral Education',

            // Higher Secondary (Class 11–12)
            'Physics',
            'Chemistry',
            'Biology',
            'Higher Mathematics',
            'Accounting',
            'Business Studies',
            'Economics',
            'Civics and Good Governance',
            'Geography and Environment',
            'History',
            'Logic',
            'Sociology',
            'Psychology',
            'Statistics',
            'Islamic History and Culture',
            'Computer Science and Applications',
            'Finance, Banking and Insurance',
            'Production Management and Marketing',
            'Entrepreneurship Development',
        ];


        foreach ($subjects as $subject) {
            DB::table('basic_subjects')->updateOrInsert(
                ['name' => $subject],
                [
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
