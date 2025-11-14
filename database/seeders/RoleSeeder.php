<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles with their permissions
        $rolesAndPermissions = [
            'Super Admin' => [
                'create-role', 'edit-role', 'delete-role',
                'create-user', 'edit-user', 'delete-user',
                'finance-view', 'finance-manage'
            ],
            'Finance Manager' => [
                'finance-view', 'finance-manage'
            ],
            'Finance Viewer' => [
                'finance-view'
            ],
            'HR Manager' => [
                'create-user', 'edit-user', 'delete-user'
            ]
        ];

        foreach ($rolesAndPermissions as $roleName => $permissions) {
            // Create role
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);

            // Get permission instances
            $permissionInstances = Permission::whereIn('name', $permissions)->get();
            
            // Assign permissions to role
            if ($permissionInstances->count() > 0) {
                $role->syncPermissions($permissionInstances);
                echo "Created role: {$roleName} with " . count($permissionInstances) . " permissions\n";
            } else {
                echo "Warning: No permissions found for role: {$roleName}\n";
            }
        }
    }
}
