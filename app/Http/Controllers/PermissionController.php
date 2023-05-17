<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function getPermissionsByModule()
    {
        try {
            $permissions = Permission::orderBy('module_id')->get();
            $groupedPermissions = [];

            foreach ($permissions as $permission) {
                $moduleName = $permission->module ? $permission->module->name : 'Sin Módulo';
                if (!array_key_exists($moduleName, $groupedPermissions)) {
                    $groupedPermissions[$moduleName] = [];
                }
                $groupedPermissions[$moduleName][] = $permission;
            }

            return response()->json([
                'success' => true,
                'data' => $groupedPermissions
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
