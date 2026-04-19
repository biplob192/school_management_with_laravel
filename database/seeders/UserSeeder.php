<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::create([
            'name'      => 'Super Admin',
            'email'     => 'superadmin@gmail.com',
            'phone'     => '01725361208',
            'role_type' => 'Super Admin',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
        ]);

        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'phone'     => '01725361209',
            'role_type' => 'Admin',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
        ]);

        $teacher = User::create([
            'name'      => 'Teacher',
            'email'     => 'teacher@gmail.com',
            'phone'     => '01725361210',
            'role_type' => 'Teacher',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
        ]);

        // Create record in the teachers table
        Teacher::create([
            'user_id' => $teacher->id
        ]);

        // $student = User::create([
        //     'name'           => 'Student',
        //     'email'          => 'student@gmail.com',
        //     'phone'          => '01725361211',
        //     'role_type'      => 'Student',
        //     'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
        // ]);

        $super_admin->assignRole('Super Admin');
        $admin->assignRole('Admin');
        $teacher->assignRole('Teacher');
        // $student->assignRole('Student');


        for ($i = 0; $i < 1000; $i++) {
            $prefixes = ['013', '014', '015', '016', '017', '018', '019'];
            $phone = $prefixes[array_rand($prefixes)] . mt_rand(10000000, 99999999);

            $data[] = [
                'name'              => fake()->name(),
                'email'             => fake()->unique()->safeEmail(),
                // 'phone'             => fake()->unique()->phoneNumber(),
                'phone'             => $phone,
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
                'role_type'         => 'Student',
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
            ];
        }

        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }

        // -------------------------------------------------------------------------------------
        // -------------------------------------------------------------------------------------

        // Assign student class
        // Fetch all active classes IDs
        // Fetch all newly inserted users' IDs
        // Assuming the users are new and last 5000 created users are these
        $classIds = DB::table('classes')->where('is_active', 1)->pluck('id')->toArray();
        // $userIds  = User::orderByDesc('id')->limit(5000)->pluck('id')->toArray();
        $userIds  = User::where('remember_token', '!=', null)->pluck('id')->toArray();

        $year          = Carbon::now()->year;
        $startingCount = Student::whereYear('created_at', $year)->count();
        $nextNumber    = $startingCount + 1;

        $students = [];
        foreach ($userIds as $userId) {
            $studentId = $year . str_pad($nextNumber++, 4, '0', STR_PAD_LEFT);

            $students[] = [
                'user_id'    => $userId,
                'custom_id'  => $studentId,
                'class_id'   => $classIds[array_rand($classIds)],   // random active class_id
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert students records in chunks
        foreach (array_chunk($students, 100) as $chunk) {
            DB::table('students')->insert($chunk);
        }


        // -------------------------------------------------------------------------------------
        // -------------------------------------------------------------------------------------

        // Assign student role
        // Get role_id of 'Student' role
        $studentRoleId = DB::table('roles')->where('name', 'Student')->value('id');

        $modelHasRoles = [];

        foreach ($userIds as $userId) {
            $modelHasRoles[] = [
                'role_id'    => $studentRoleId,
                'model_type' => 'App\Models\User',
                'model_id'   => $userId,
            ];
        }

        foreach (array_chunk($modelHasRoles, 100) as $chunk) {
            DB::table('model_has_roles')->insert($chunk);
        }
    }
}
