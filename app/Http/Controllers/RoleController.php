<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assignPermission(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required|exists:permissions,name',
        ]);

        $role = Role::findOrFail($roleId);
        $permissionName = $request->input('permission');
        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $role->givePermissionTo($permission);

        //return redirect()->back()->with('success', 'Permission assigned to role successfully.');

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' =>
            'success', 'Permission assigned to role successfully.'
        ], 200);
    }
}
