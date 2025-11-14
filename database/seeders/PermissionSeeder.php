<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role' => ['name_view' => 'Role', 'action_name' => 'CREATE'],
            'edit-role' => ['name_view' => 'Role', 'action_name' => 'UPDATE'],
            'delete-role' => ['name_view' => 'Role', 'action_name' => 'DELETE'],
            'create-user' => ['name_view' => 'ผู้ใช้งาน', 'action_name' => 'CREATE'],
            'edit-user' => ['name_view' => 'ผู้ใช้งาน', 'action_name' => 'UPDATE'],
            'delete-user' => ['name_view' => 'ผู้ใช้งาน', 'action_name' => 'DELETE'],
            'finance-view' => ['name_view' => 'ข้อมูลการเงิน', 'action_name' => 'VIEW'],
            'finance-manage' => ['name_view' => 'ข้อมูลการเงิน', 'action_name' => 'MANAGE']
         ];
 
          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission => $attributes) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                array_merge($attributes, ['guard_name' => 'web'])
            );
          }
    }
}
