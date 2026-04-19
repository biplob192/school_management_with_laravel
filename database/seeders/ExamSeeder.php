<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = [
            ['name' => 'First Term Exam', 'start_month' => 1, 'end_month' => 3],
            ['name' => 'Half Yearly Exam', 'start_month' => 4, 'end_month' => 6],
            ['name' => 'Second Term Exam', 'start_month' => 7, 'end_month' => 9],
            ['name' => 'Final Exam', 'start_month' => 10, 'end_month' => 12],
        ];

        foreach ($exams as $exam) {
            DB::table('exams')->updateOrInsert(
                ['name' => $exam['name']],
                [
                    'start_month' => $exam['start_month'],
                    'end_month'   => $exam['end_month'],
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}
