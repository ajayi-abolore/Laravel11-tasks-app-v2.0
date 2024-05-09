<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    //

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function assignRole(Request $request, $userId, $roleName)
    {

        $request->validate([
            'role_name' => 'required|exists:roles,name',
        ]);
        $user = User::find($userId);
        if (!$user) {
            //return redirect()->back()->with('error', 'User not found.');
            return response()->json([
                'success' => true,
                'statusCode' => 422,
                'message' => 'Error', 'User not found. '
            ], 422);
        }

        $roleName = $request->input('role_name');
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            //return redirect()->back()->with('error', 'Role not found.');
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'error', 'Role not found.'
            ], 200);
        }

        if ($user->hasRole($roleName)) {

            return response()->json([
                'success' => true,
                'statusCode' => 422,
                'message' => 'error', 'User already has this role. '
            ], 422);
        }
        $user->assignRole($role);
        //$user = User::find($userId);
        //$user->roles()->attach($roleN);
        // return redirect()->back()->with('success', 'Role assigned successfully.');
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Role Assiged Successfull '
        ], 200);
    }
}
