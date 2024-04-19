<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ApexController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Email address is required.',
                'email.email' => 'Enter a valid email address.',
                'password.required' => 'Enter your password.',
            ]
        );

        if ($validator->fails()) {
            $validator->errors();
            $validator->errors()->toJson();
            return response()->json([
                'status' => 201,
                'message' => 'An error occured.',
                'errors' => $validator->errors()
            ]);
        }
        $credentials = $request->only('email', 'password');
        $credentials = ['email' => request('email'), 'password' => request('password')];

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 201,
                'message' => 'Unauthorized',
                'errors' => [
                    'message' => 'Either your email address or password is not correct.'
                ]
            ]);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 200,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function createaccount(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ],
            [
                'name.required' => 'Your name is required.',
                'name.max' => 'The name you entered is too long.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Enter a valid email address.',
                'email.unique' => 'The email address you entered is already in use.',
                'password.required' => 'Your password is required.',
                'password.min' => 'Your password must be up to 6 characters.',
            ]
        );

        if ($validator->fails()) {
            $validator->errors();
            $validator->errors()->toJson();
            return response()->json([
                'status' => 201,
                'message' => 'Unable to create your account.',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => ucwords($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 201,
                'message' => 'User not created.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function viewallusers()
    {
        $allusers = User::all();
        return response()->json([
            'status' => 'success',
            'users' => $allusers,
        ]);
    }

    public function viewuser($id)
    {
        $thisuser = User::find($id);
        if ($thisuser) {
            return response()->json([
                'status' => 'success',
                'userdetails' => $thisuser,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ]);
        }
    }

    public function deleteuser($id)
    {
        $thisuser = User::find($id);
        if (!$thisuser) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ]);
        }

        if ($thisuser->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not deleted',
            ]);
        }
    }

    public function updateuser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|string',
                'id' => 'required|integer',
            ],
            [
                'name.required' => 'Your name is required.',
                'name.max' => 'The name you entered is too long.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Enter a valid email address.',
                'email.unique' => 'The email address you entered is already in use.',
                'role.required' => 'The user\'s roleis required.',
                'id.required' => 'The user\'s id is required.',
                'id.integer' => 'The user\'s id must be a number.',
            ]
        );

        if ($validator->fails()) {
            $validator->errors();
            $validator->errors()->toJson();
            return response()->json([
                'status' => 201,
                'message' => 'Unable to update this account.',
                'errors' => $validator->errors()
            ]);
        }

        $thisuser = User::find($request->id);
        if (!$thisuser) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ]);
        }

        $updateuser = $thisuser->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($updateuser) {
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not updated',
            ]);
        }
    }
}
