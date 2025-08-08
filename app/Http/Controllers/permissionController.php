<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', [permission::class]);
        $permissions = Permission::all();
        return response()->view('role-permission.permissions', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(permission $permission)
    {
        $this->authorize('delete', [permission::class]);
        $deletedCount = $permission->delete();
        return redirect()->back()->with([
            'status' => true,
            'icon' => $deletedCount ? 'success' : 'error',
            'message' =>  $deletedCount ? "تم الحذف بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }
}
