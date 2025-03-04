<?php

namespace Database\Seeders;

use App\Enums\ModelsEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{

    public function setupAllModelsPermissions() {

        $models = ModelsEnum::getAllModels();
        foreach ($models as $model) {
            $permissions = ['layout', 'view', 'write', 'create'];
            foreach ($permissions as $permission) {
                $permissionName = $permission . '-' . $model;
                $existingPermission = Permission::where('name', $permissionName)->where('guard_name', 'web')->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
                }
            }
        }

        $admin = User::find(1);
        if ($admin) {
            $allPermissions = Permission::all();
            $admin->syncPermissions($allPermissions);
        }
    }

    public function run()
    {
        $this->setupAllModelsPermissions();
    }
}
