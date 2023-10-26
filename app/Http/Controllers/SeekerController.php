<?php

namespace App\Http\Controllers;

use App\Mail\SeekerOtp;
use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SeekerController extends Controller
{
    public function registerSeeker(Request $request)
    {
        $email = $request->email;
        $otp = rand(100000, 999999);

        if (!Seeker::where(['email' => $request->email, 'is_active' => 1])->exists()) {

            Mail::to($email)->send(new SeekerOtp($otp));

            $seeker_details = Seeker::create([
                'fullname' => $request->fullname,
                'email' => $email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'is_active' => 0,
                'otp' => $otp
            ]);
            return response()->json([
                'message' => 'Seeker OTP send successfully',
                'success' => 200,
                'seeker_id' => $seeker_details->id
            ]);
        } else {
            return response()->json([
                'message' => 'Account Already exist',
                'error' => 100
            ]);
        }
    }
    public function validateOtp(Request $request)
    {

        if (Seeker::where(['id' => $request->seeker_id, 'otp' => $request->otp])->exists()) {
            Seeker::where('id', $request->seeker_id)
                ->update(['is_active' => 1]);

            return response()->json([
                'message' => 'Otp verified sucessfully',
                'success' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid OTP',
                'error' => 100
            ]);
        }
    }

    public function addSeekerDetails(Request $request)
    {
        if ($request->hasFile('pdf')) {

            $fileName = time() . '.' . $request->file('pdf')->extension();
            $request->file('pdf')->move(public_path('pdf'), $fileName);

            Seeker::where('id', $request->seeker_id)
                ->update([
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'contact_number' => $request->contact_number,
                    'work_authorization' => $request->work_authorization,
                    'total_experience' => $request->total_experience,
                    'primary_skill' => $request->primary_skill,
                    'primary_skill_experience' => $request->primary_experience,
                    'secondary_skill' => $request->secondary_skill,
                    'secondary_skill_experience' => $request->secondary_experience,
                    'resume' => $fileName
                ]);




            // You may want to store the filename in the database or perform other actions here.

            return response()->json([
                'message' => 'Details added successfully',
                'success' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'No PDF file provided',
                'error' => 100,
            ]);
        }
    }

    public function loginSeeker(Request $request)
    {

        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);
        // $seeker = Seeker::where('email', $request->email)->first();
        // // dd($seeker);
        // if (!$seeker || !Hash::check($request->password, $seeker->password)) {
        //     return response()->json([
        //         'message' => 'Invalid credentials',
        //         'code' => 100
        //     ]);
        // }
        // $token = $seeker->createToken('SeekerToken')->plainTextToken;

        // return response()->json([
        //     'message' => 'Login successful',
        //     'token' => $token
        // ], 200);



        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('seeker')->attempt(['email' => $request->email, 'password'  => $request->password])) {

            return response()->json([
                'message' => 'Login successfull',
                'success' => 200,
            ]);
        }
        return response()->json([
            'message' => 'Please try agian letter',
            'success' => 100,
        ]);
    }
}
