<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;

class RoleController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $slug = $request->slug;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        $roles = Role::when($name, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($slug, function ($query, $slug) {
                return $query->where('slug', 'like', '%' . $slug . '%');
            })
            ->when($sortField && $sortDirection, function ($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            }, function ($query) {
                return $query->orderBy('created_at', "desc");
            })
            ->paginate($perPage);


        $roles->map(function ($created) {
            $created->formatted_date = Carbon::parse($created->created_at)->format('d/m/Y H:i:s');
            return $created;
        });

        return response()->json([
            'success' => true,
            'data' => $roles
        ], Response::HTTP_OK,);
    }

    public function saveRole(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role = new Role([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
        ]);


        $role->save();

        $permissions = Permission::whereIn('id', $request->input('permissions'))->get();

        $role->permissions()->sync($permissions);

        $new_role = [
            'name' => $role->name,
            'slug' => $role->slug,
            'permissions' => $role->permissions()->pluck('name'),
        ];

        $logData = [
            'user_id' => Auth::id(),
            'model' => 'Roles',
            'action' => 'Crear',
            'ip' => $request->ip(),
            'data' => [
                'new_role' => $new_role
            ],
        ];

        $this->activityLogService->createLog(
            $logData['user_id'],
            $logData['model'],
            $logData['action'],
            $logData['ip'],
            $logData['data']
        );

        return response()->json([
            'success' => true,
            'data' => $role,
        ], Response::HTTP_CREATED);
    }

    public function updateRole(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'permissions' => 'required|array'
        ]);

        $role = Role::find($id);
        $oldRoleData = $role->toArray();
        $oldPermissions = $role->permissions()->pluck('id')->toArray();
        sort($oldPermissions);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $role->name = $validatedData['name'];
        $role->slug = $validatedData['slug'];
        $role->save();

        $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
        $role->permissions()->sync($permissions);

        $newPermissions = $role->permissions()->pluck('id')->toArray();
        sort($newPermissions);
        $roleChanges = $this->compareChanges($oldRoleData, $validatedData);
        $permissionChanges = $this->compareChanges(['permissions' => $oldPermissions], ['permissions' => $newPermissions]);

        if (!empty($roleChanges) || !empty($permissionChanges)) {

            $updateFields = [
                'name' => $role->name,
                'slug' => $role->slug,
                'permissions' => $role->permissions()->pluck('name'),
            ];

            $logData = [
                'user_id' => Auth::id(),
                'model' => 'Roles',
                'action' => 'Actualizar',
                'ip' => $request->ip(),
                'data' => [
                    'update_role' => $updateFields
                ],
            ];

            $this->activityLogService->createLog(
                $logData['user_id'],
                $logData['model'],
                $logData['action'],
                $logData['ip'],
                $logData['data']
            );
        }

        return response()->json([
            'success' => true,
            'data' => $role,
        ], Response::HTTP_OK);
    }

    public function getRolePermissions($id)
    {
        $role = Role::with('permissions')->find($id);

        return response()->json([
            'success' => true,
            'data' => $role->permissions->toArray(),
        ], Response::HTTP_OK);
    }

    public function getRole($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $role,
        ],  Response::HTTP_OK);
    }

    public function getAllRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function deleteRole(Request $request, $id)
    {

        if ($id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el rol de administrador',
            ], Response::HTTP_FORBIDDEN);
        }

        $role = Role::find($id);

        if ($role) {
            $role->permissions()->detach();
            $role->users()->detach();
            $role->delete();

            $logData = [
                'user_id' => Auth::id(),
                'model' => 'Roles',
                'action' => 'Eliminar',
                'ip' => $request->ip(),
                'data' => [
                    'delete_role' => [
                        'role' => $id,
                    ]
                ],
            ];

            $this->activityLogService->createLog(
                $logData['user_id'],
                $logData['model'],
                $logData['action'],
                $logData['ip'],
                $logData['data']
            );

            return response()->json(['message' => 'Role deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Role not found'], 404);
        }
    }

    public function compareChanges($oldData, $newData)
    {
        $changes = [];

        foreach($newData as $key => $value) {
            if (array_key_exists($key, $oldData) && $oldData[$key] !== $newData[$key]) {
                $changes[$key] = [
                    'old' => $oldData[$key],
                    'new' => $newData[$key],
                ];
            }
        }

        return $changes;
    }
}
