<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use DB;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $name = $request->name;
        $state = $request->state;
        $perPage = $request->perPage;
        $sortField = $request->sort_field;
        $sortDirection = $request->sort_direction;

        $users = User::with('file')
            ->when($name, function ($query, $name) {
                return $query->whereRaw('CONCAT(firstname, " ", lastname) LIKE ?', ['%' . $name . '%']);;
            })
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->when($sortField && $sortDirection, function ($query) use ($sortField, $sortDirection) {
                return $query->orderBy($sortField, $sortDirection);
            }, function ($query) {
                return $query->orderBy('created_at', "desc");
            })
            ->paginate($perPage);

        $users->map(function ($created) {
            $created->formatted_date = Carbon::parse($created->created_at)->format('d/m/Y H:i:s');
            return $created;
        });

        return response()->json([
            'success' => true,
            'data' => $users,
        ], Response::HTTP_OK);
    }

    public function updateState(Request $request, $id)
    {
        if ($id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para cambiar el estado de este usuario.',
            ], Response::HTTP_FORBIDDEN);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $user->state = $request->state;
        $user->save();

        return response()->json([
            'success' => true,
        ], Response::HTTP_CREATED);
    }

    public function saveUser(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'selected_image' => 'sometimes|string',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = new User([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $file = null;

        if ($request->has('selected_image')) {
            $file = $this->saveSelectedImage($request->selected_image);
        }

        DB::transaction(function () use ($user, $file, $validatedData) {
            $user->save();
            $user->roles()->attach($validatedData['roles']);

            if ($file) {
                $user->file_id = $file->id;
                $user->update();
            }
        });

        return response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function saveSelectedImage($filename)
    {
        $imagePath = 'images/users/' . $filename;

        $file = new File([
            'path' => $imagePath,
            'filename' => $filename
        ]);

        $file->save();

        return $file;
    }

    public function updateUser(Request $request, $id)
    {
        if ($id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar este usuario.',
            ], Response::HTTP_FORBIDDEN);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',id',
            'password' => 'sometimes|string|min:8|confirmed',
            'selected_image' => 'nullable|string',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }


        $file = null;

        if ($request->has('selected_image')) {
            if ($user->file_id) {
                $file = $user->file;
                $file->path = 'images/users/' . $request->selected_image;
                $file->filename = $request->selected_image;
                $file->save();
            } else {
                $file = $this->saveSelectedImage($request->selected_image);
            }
        }


        DB::transaction(function () use ($user, $file, $validatedData) {
            $user->update();
            $user->roles()->sync($validatedData['roles']);

            if ($file) {
                $user->file_id = $file->id;
                $user->update();
            }
        });

        return response()->json([
            'success' => true,
            'data' => $user,

        ]);

        return response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'sometimes|string|min:8|confirmed',
            'selected_image' => 'nullable|string',
        ]);

        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }


        $file = null;

        if ($request->has('selected_image')) {
            if ($user->file_id) {
                $file = $user->file;
                $file->path = 'images/users/' . $request->selected_image;
                $file->filename = $request->selected_image;
                $file->save();
            } else {
                $file = $this->saveSelectedImage($request->selected_image);
            }
        }


        DB::transaction(function () use ($user, $file) {
            $user->update();

            if ($file) {
                $user->file_id = $file->id;
                $user->update();
            }
        });

        return response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function getUser($id)
    {
        $user = User::with('file', 'roles')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user);
    }

    public function getRolePermissions(Request $request)
    {
        $userId = $request->userId;

        if (!$userId) {
            $userId = Auth::id();
        }

        $user = User::find($userId);
        $permissions = $user->permissionsByRole;
        $slugs = $permissions->pluck('slug');

        return response()->json($slugs);
    }

    public function getProfile(Request $request)
    {

        if ($request->ajax()) {

            $user = User::with('file', 'roles')->find(Auth::id());

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($user);
        }
    }

}
