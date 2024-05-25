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

    public function getPermissionRole($request)
    {
        return Permission::where('module', $request->module)->get();
    }
}