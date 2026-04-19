<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        // $superAdminRole         = Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);
        // $adminRole              = Role::create(['name' => 'Admin', 'guard_name' => 'api']);
        // $editorRole             = Role::create(['name' => 'Editor', 'guard_name' => 'api']);
        // $employeeRole           = Role::create(['name' => 'Employee', 'guard_name' => 'api']);
        // $userRole               = Role::create(['name' => 'User', 'guard_name' => 'api']);

        // Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        // Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        // Role::create(['name' => 'Editor', 'guard_name' => 'web']);
        // Role::create(['name' => 'Employee', 'guard_name' => 'web']);
        // Role::create(['name' => 'User', 'guard_name' => 'web']);

        $superAdminRole  = Role::create(['name' => 'Super Admin']);
        $adminRole       = Role::create(['name' => 'Admin']);
        $schoolAdminRole = Role::create(['name' => 'School Admin']);
        $teacherRole     = Role::create(['name' => 'Teacher']);
        $studentRole     = Role::create(['name' => 'Student']);


        // Permissions
        // $createPermission       = Permission::create(['name' => 'create', 'guard_name' => 'api']);
        // $readPermission         = Permission::create(['name' => 'read', 'guard_name' => 'api']);
        // $updatePermission       = Permission::create(['name' => 'update', 'guard_name' => 'api']);
        // $deletePermission       = Permission::create(['name' => 'delete', 'guard_name' => 'api']);
        // $createAdminPermission  = Permission::create(['name' => 'create.admins', 'guard_name' => 'api']);

        $createPermission           = Permission::create(['name' => 'create']);
        $readPermission             = Permission::create(['name' => 'read']);
        $updatePermission           = Permission::create(['name' => 'update']);
        $deletePermission           = Permission::create(['name' => 'delete']);
        $createAdminPermission      = Permission::create(['name' => 'create.admin']);
        $createTeacherPermission    = Permission::create(['name' => 'create.teacher']);
        $createSuperAdminPermission = Permission::create(['name' => 'create.super_admin']);

        // Assign permissions to super_admin role
        $superAdminRole->givePermissionTo($createPermission);
        $superAdminRole->givePermissionTo($readPermission);
        $superAdminRole->givePermissionTo($updatePermission);
        $superAdminRole->givePermissionTo($deletePermission);
        $superAdminRole->givePermissionTo($createAdminPermission);
        $superAdminRole->givePermissionTo($createTeacherPermission);
        $superAdminRole->givePermissionTo($createSuperAdminPermission);

        // Assign permissions to admin role
        $adminRole->givePermissionTo($createPermission);
        $adminRole->givePermissionTo($readPermission);
        $adminRole->givePermissionTo($updatePermission);
        $adminRole->givePermissionTo($deletePermission);
        $adminRole->givePermissionTo($createAdminPermission);

        // Assign permissions to school admin role
        $schoolAdminRole->givePermissionTo($createPermission);
        $schoolAdminRole->givePermissionTo($readPermission);
        $schoolAdminRole->givePermissionTo($updatePermission);
        $schoolAdminRole->givePermissionTo($deletePermission);
        $schoolAdminRole->givePermissionTo($createTeacherPermission);

        // Assign permissions to teacher role
        $teacherRole->givePermissionTo($createPermission);
        $teacherRole->givePermissionTo($readPermission);
        $teacherRole->givePermissionTo($updatePermission);
        $teacherRole->givePermissionTo($deletePermission);

        // Assign permissions to student role
        $studentRole->givePermissionTo($readPermission);
    }
}
