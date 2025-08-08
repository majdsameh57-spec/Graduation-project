<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    
    
    public function index()
    {
        $admin = Admin::with('roles')->withCount('permissions')->get();
        return response()->view('admin.index', ['admins' => $admin]);
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return response()->view('admin.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->symbols()
                    ->letters()
                    ->numbers()
                    ->uncompromised()
            ],
            'image' => 'required|image|mimes:jpg,png,jpeg,gif',
            'role_id' => 'nullable|numeric|exists:roles,id'
        ]);

        $admin = new admin();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->mobile = $request->input('mobile');
        $admin->password = Hash::make($request->input('password'));
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->store('admins', ['disk' => 'public']);
            $admin->image = $imageName;
        }
        $isSaved = $admin->save();
        $role = Role::where('id', $request->input('role_id'))
            ->where('guard_name', 'admin')
            ->first();
        if ($role) {
            $admin->assignRole($role->name);
        }
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    public function editUserPermission(Request $request, admin $admin)
    {
        $this->authorize('editPermission', [admin::class]);
        $role = $admin->roles->first();
        if (!$role) {
            return redirect()->back()->with('error', 'المستخدم لا يمتلك دورًا.');
        }

        $rolePermissions = $role->permissions;
        $adminPermissions = $admin->permissions->pluck('id')->toArray();
        if (count($adminPermissions)) {
            foreach ($adminPermissions as $adminPermission) {
                foreach ($rolePermissions as $rolePermission) {
                    if (in_array($rolePermission->id, $adminPermissions)) {
                        $rolePermission->setAttribute('assigned', true);
                    } else {
                        $rolePermission->setAttribute('assigned', false);
                    }
                }
            }
        }
        return response()->view('admin.adminPermission', ['admin' => $admin, 'role' => $role, 'rolePermission' => $rolePermissions, 'adminPermission' => $adminPermissions]);
    }
    public function updateUserPermission(Request $request, admin $admin)
    {
        $this->authorize('updatePermission', [admin::class]);
        $validator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission = Permission::findById($request->input('permission_id'));

        // نتحقق من الصلاحيات المباشرة فقط
        $hasDirectPermission = $admin->permissions->contains('id', $permission->id);

        if ($hasDirectPermission) {
            $admin->revokePermissionTo($permission);
        } else {
            $admin->givePermissionTo($permission);
        }

        return response()->json(['status' => true, 'message' => 'Permission Updated']);
    }



    public function edit(admin $admin)
    {
        $this->authorize('update', [admin::class]);
        $roles = Role::where('guard_name', 'admin')->get();
        return response()->view('admin.update', ['data' => $admin, 'roles' => $roles]);
    }

    public function update(Request $request, admin $admin)
    {
        $this->authorize('update', [admin::class]);
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'mobile' => 'required|string|max:20',
            'role_id' => 'nullable|numeric|exists:roles,id'
        ]);

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->mobile = $request->input('mobile');
        $isSaved = $admin->save();
        $role = Role::where('id', $request->input('role_id'))
            ->where('guard_name', 'admin')
            ->first();
        if ($role) {
            $admin->syncRoles([$role->name]);
        }
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تم التحديث بنجاح" : "فشل التحديث"
        ]);
    }



    public function profile()
    {
        $admin = auth('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function editProfile()
    {
        $admin = auth('admin')->user();
        return view('admin.edit-profile', compact('admin'));
    }
}
