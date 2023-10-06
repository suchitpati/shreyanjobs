<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SeekerController extends Controller
{
    public function registerSeeker(Request $request)
    {
        if(!Seeker::where('email',$request->email)->exists())
        {

            Seeker::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender
            ]);
            return response()->json([
                'message' => 'Seeker Registered successfully',
                'success' => 200
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'Account Already exist',
                'error' => 100
            ]);
        }
    }

}
