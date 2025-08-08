<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class roleController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Role::class, 'role');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny', [Role::class]);
        //
        $roles = Role::withCount('permissions')->get();
        return response()->view('role-permission.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', [Role::class]);
        //
        $guards = [
            ['name' => 'admin', 'value' => 'admin'],
            ['name' => 'merchant', 'value' => 'merchant'],
        ];
        return response()->view('role-permission.create', ['guards' => $guards]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $this->authorize('create', [Role::class]);
        $request->validate([
            'name' => 'required|string',
            'guard' => 'required|string|in:admin,merchant',
        ]);



        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard');
        $role->save();
        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : 'error',
            'message' =>  true ? "تمت حفظ البيانات بنجاح" : " !حدث خطأ"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        // $this->authorize('view', [Role::class]);

        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();
        $rolePermissions = $role->permissions;
        //

        if (count($rolePermissions)) {
            foreach ($rolePermissions as $userPermission) {
                foreach ($permissions as $permission) {
                    if ($permission->id === $userPermission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }

        return response()->view('role-permission.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }

    public function updateRolePermission(Request $request)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if (!$validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            $role = Role::findOrFail($request->input('role_id'));
            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission)
                : $role->givePermissionTo($permission);
            return response()->json(['status' => true, 'message' => 'Permission Updated']);
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        $this->authorize('update');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
