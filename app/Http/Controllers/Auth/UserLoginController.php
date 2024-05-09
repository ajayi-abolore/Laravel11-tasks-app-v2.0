<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserLoginController extends Controller
{
    //
    public function login(Request $request): JsonResponse
    {
        // Validation ..............
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $User = User::where('email', $request->email)->first();

        if (is_null($User)) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'No Account Found for this User !!!'
            ], 400);
        } else {

            if (!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $accessToken = $User->createToken('auth_token')->plainTextToken;
            $user        = Auth::user();

            return response()->json([
                'success'       => true,
                'access_token'  => $accessToken,
                'token_type'    => 'Bearer',
                'statusCode'    => 200,
                'user'          => $user,
                'message'          => 'Welcome from login page' . $user
            ], 200);
        }
    }
}
