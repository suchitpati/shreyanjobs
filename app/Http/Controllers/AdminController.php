<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        // dd($admin);
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => 100
            ]);
        }

        $token = $admin->createToken('AdminToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->where('name', 'AdminToken')->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function getAdmin()
    {
        $admins = Admin::all();

        return response()->json($admins);
    }

    public function changePassword(Request $request, $id)
    {

        $validatedData = $request->validate([
            'email' => 'nullable',
            'password' => 'required',
        ]);


        $admin = Admin::findOrFail($id);
        $admin->email = $request->email;
        $admin->password = Hash::make($validatedData['password']);
        $admin->update();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

}
