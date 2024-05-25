<?php

namespace App\Http\Controllers\Auth;

use App\Cms\RolePermission\PermissionRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function getRepo(): PermissionRepo
    {
        return new PermissionRepo();
    }

    public function getPermissionRole($module)
    {
        try {
            return jsend_success($this->getRepo()->getPermissionRole($module));
        } catch (\Exception $e) {
            return jsend_error('Error: '.$e->getMessage());
        }
    }
}
