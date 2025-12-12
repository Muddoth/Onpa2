<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Define all permissions
        $permissions = [
            'view songs',
            'create songs',
            'edit songs',
            'delete songs',

        ];

        // 2️⃣ Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3️⃣ Create roles
        $admin = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value, 'guard_name' => 'web']);
        $artist = Role::firstOrCreate(['name' => RoleEnum::ARTIST->value, 'guard_name' => 'web']);
        $listener = Role::firstOrCreate(['name' => RoleEnum::LISTENER->value, 'guard_name' => 'web']);

        // 4️⃣ Assign permissions to roles
        $admin->givePermissionTo(Permission::all()); // Admin gets all permissions
        $artist->givePermissionTo([
            PermissionEnum::VIEW_SONGS->value,
            PermissionEnum::CREATE_SONGS->value,
            PermissionEnum::EDIT_SONGS->value,
            PermissionEnum::DELETE_SONGS->value,
        ]);
        
        $listener->givePermissionTo(PermissionEnum::VIEW_SONGS);

    }
}
