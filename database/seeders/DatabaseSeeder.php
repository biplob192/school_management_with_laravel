<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Run the following command menually if needed
        // php artisan db:seed --class=RolesAndPermissionsSeeder
        // php artisan db:seed --class=PassportDefaultClientSeeder


        $this->call([
            RolesAndPermissionsSeeder::class,
            GroupSeeder::class,
            SectionSeeder::class,
            BasicSubjectSeeder::class,
            SchoolClassSeeder::class, // With ClassGroup and ClassSection Seeders
            SubjectSeeder::class,
            DesignationSeeder::class,
            UserSeeder::class, // With Student and Teacher Seeders
            SubjectTeacherSeeder::class,
        ]);
    }
}
