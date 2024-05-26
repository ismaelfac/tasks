<?php

namespace App\Cms\RolePermission;

use App\Cms\BaseRepo\BaseRepo;
use App\Models\Permission;

class PermissionRepo extends BaseRepo
{
    public function getModel(): Permission
    {
        return new Permission();
    }

    public function getPermissionRole($module)
    {
        return Permission::where('module', $module)->get();
    }
}