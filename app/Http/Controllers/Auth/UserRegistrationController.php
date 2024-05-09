<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegistrationController extends Controller
{
    //
    public function register(Request $request)
    : JsonResponse
    {

        $request->validate([
            'name'      => 'required|',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required',
        ]);

        $User = User::where('email', $request->email)->first();

        if (!is_null($User)) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'Oops, This User Already Exist !!!'
            ], 400);

        } else {

            try {

                $Create             = new User();
                $Create->name       = $request->name;
                $Create->email      = $request->email;
                $Create->password   = Hash::make($request->password);
                $Create->save();

                $token = $Create->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success'       => true,
                    'statusCode'    => 200,
                    'access_token'  => $token,
                    'token_type'    => 'Bearer',
                    'message'       => 'Account Successfully Created !!!'
                ], 200);

            } catch(Exception $e) {

                return response()->json([
                    'success'       => false,
                    'statusCode'    => 400,
                    'message'       => $e
                ], 400);

            }

        }

    }

}
