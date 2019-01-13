<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsAndRolesSeeder extends Seeder
{
    public function run()
    {
        if ($this->command->confirm('Seed permissions and roles tables?')) {
            $tableNames = config('permission.table_names');

            if ($this->command->confirm('Clear permissions and roles tables first?', true)) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table($tableNames['model_has_permissions'])->truncate();
                DB::table($tableNames['model_has_roles'])->truncate();
                DB::table($tableNames['role_has_permissions'])->truncate();
                DB::table($tableNames['permissions'])->truncate();
                DB::table($tableNames['roles'])->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            $rolesTree = [
                Role::ROOT => [
                    Permission::VIEW_USERS, Permission::MODIFY_USERS,
                ],
                Role::ADMIN => [
                    Permission::VIEW_USERS
                ],
            ];

            Model::unguard();

            foreach ($rolesTree as $roleName => $permissionNames) {
                $role = Role::query()
                    ->where('name', $roleName)
                    ->first();
                if (!$role instanceof Role) {
                    $role = Role::create(['name' => $roleName]);
                }
                foreach ($permissionNames as $permissionName) {
                    $permission = Permission::query()
                        ->where('name', $permissionName)
                        ->first();
                    if (!$permission instanceof Permission) {
                        $permission = Permission::create(['name' => $permissionName]);
                    }
                    $role->givePermissionTo($permission);
                }
            }

            Model::reguard();

            $this->command->info('Permissions and roles tables seeded!');
        }
    }
}
