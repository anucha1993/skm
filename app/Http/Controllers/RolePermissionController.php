<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role', ['only' => ['createRole', 'storeRole']]);
        $this->middleware('permission:edit-role', ['only' => ['editRole', 'updateRole']]);
        $this->middleware('permission:delete-role', ['only' => ['destroyRole']]);
    }

    /**
     * Display roles and permissions management
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all()->groupBy('action_name');
        $users = User::with('roles')->get();
        
        return view('admin.roles-permissions.index', compact('roles', 'permissions', 'users'));
    }

    /**
     * Store a new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Role created successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error creating role: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update role permissions
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'array'
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions($request->permissions ?? []);
            
            return response()->json([
                'success' => true,
                'message' => 'Role permissions updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'array'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $user->syncRoles($request->roles ?? []);
            
            return response()->json([
                'success' => true,
                'message' => 'User roles updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning role: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete role
     */
    public function destroyRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user permissions for finance section
     */
    public function getUserFinancePermissions($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $financePermissions = $user->getAllPermissions()
                ->filter(function ($permission) {
                    return str_contains($permission->name, 'finance');
                });
            
            return response()->json([
                'success' => true,
                'permissions' => $financePermissions->pluck('name')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving permissions: ' . $e->getMessage()
            ]);
        }
    }
}