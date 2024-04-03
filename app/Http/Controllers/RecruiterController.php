<?php

namespace App\Http\Controllers;

use App\Mail\RecruiterMail;
use Illuminate\Http\Request;
use App\Models\Recruiter;
use App\Mail\RecruiterOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Date;

class RecruiterController extends Controller
{

    public function recruiter_register(Request $request)
{
    $email = $request->email;
    $otp = rand(100000, 999999);

    $maildata = [
        'title' => 'Varification OTP',
        'body' => 'Your OTP is ' . $otp,
    ];

    if (Recruiter::where(['emailid' => $email, 'is_active' => 1])->exists()) {
        return response()->json([
            'message' => 'Account Already exist',
            'error' => 100
        ]);
    } elseif (Recruiter::where(['emailid' => $email, 'is_active' => 0])->exists()) {
        Mail::to($email)->send(new RecruiterOtpMail($maildata));

        Recruiter::where('emailid', $email)->update([
            'fullname' => $request->fullname,
            'contactno' => $request->contactno,
            'password' => Hash::make($request->password),
            'companyname' => $request->companyname,
            'companyurl' => $request->companyurl,
            //'last_login_date' => $request->last_login_date,
            'otp' => $otp,
            'is_active' => 0,
        ]);

        $recruiter = Recruiter::where('emailid', $email)->first();

        return response()->json([
            'message' => 'Recruiter OTP sent successfully',
            'success' => 200,
            'recruiter_id' => $recruiter->id
        ]);
    } elseif (Recruiter::where(['emailid' => $email, 'is_active' => 1])->exists()) {
        Mail::to($email)->send(new RecruiterOtpMail($maildata));

        Recruiter::where('emailid', $email)->update([
            'fullname' => $request->fullname,
            'contactno' => $request->contactno,
            'password' => Hash::make($request->password),
            'companyname' => $request->companyname,
            'companyurl' => $request->companyurl,
           // 'last_login_date' => $request->last_login_date,
            'otp' => $otp,
            'is_active' => 0,
        ]);

        $recruiter = Recruiter::where('emailid', $email)->first();

        return response()->json([
            'message' => 'Recruiter OTP sent successfully',
            'success' => 200,
            'recruiter_id' => $recruiter->id
        ]);
    } else {
        Mail::to($email)->send(new RecruiterOtpMail($maildata));

        $recruiter = Recruiter::create([
            'fullname' => $request->fullname,
            'emailid' => $email,
            'contactno' => $request->contactno,
            'password' => Hash::make($request->password),
            'companyname' => $request->companyname,
            'companyurl' => $request->companyurl,
            // 'last_login_date' => $request->last_login_date,
            'otp' => $otp,
            'is_active' => 0,
        ]);
        // return response()->json(['message'=>$recruiter]);
        return response()->json([
            'message' => 'Recruiter OTP sent successfully',
            'success' => 200,
            'recruiter_id' => $recruiter->id
        ]);
    }
}
public function validateOtp(Request $request)
{
    if (Recruiter::where(['otp' => $request->otp])->exists()) {
        Recruiter::where('id', $request->recruiter_id)
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

public function loginrecruiter(Request $request){
    $recruiter = Recruiter::where(['emailid' => $request->email])->first();
    // return response()->json(['emailid' => $request->email]);
    if ($recruiter == null || $recruiter == '') {
        return response()->json([
            'message' => 'Email not found',
            'code' => 100
        ]);
    }
    // if ($recruiter->is_active == 0) {
    //     return response()->json([
    //         'message' => 'Your Account Registration did not complete last time. Please re-register the account',
    //         'code' => 100
    //     ]);
    // }
    if (!$recruiter || !Hash::check($request->password, $recruiter->password)) {
        return response()->json([
            'message' => 'Invalid credentials',
            'code' => 100
        ]);
    }

    // $token = $recruiter->createToken('RecruiterToken')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        // 'token' => $token,
        'recruiter_id' => $recruiter->id,
        'role' => $recruiter->role,
    ], 200);

}


public function recruiterLogout(Request $request)
{
    $user = $request->user();

    $user->tokens()->where('fullname', 'RecruiterToken')->delete();

    return response()->json(['message' => 'Logged out successfully'], 200);
}



public function sendForgotEmailOtp(Request $request)
{
    $otp = rand(100000, 999999);

    $maildata = [
        'title' => 'mail from Shreyanjobs',
        'body' => 'Your otp for forgot password is ' . $otp,
    ];


    if (Recruiter::where(['emailid' => $request->email])->exists()) {
        Recruiter::where(['emailid' => $request->email])
            ->update(['otp' => $otp]);
        Mail::to($request->email)->send(new RecruiterMail($maildata));

        return response()->json([
            'message' => 'Otp send sucessfully',
            'success' => 200,
            'emailid' => $request->email
        ]);
    } else {
        return response()->json([
            'message' => 'email id not found',
            'error' => 100,
        ]);
    }
}

public function checkForgotOtp(Request $request)
    {
          if (Recruiter::where(['otp' => $request->otp])->exists()) {
        Recruiter::where('id', $request->recruiter_id)
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

    public function updateForgotPassword(Request $request)
    {
        Recruiter::where('emailid', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'password updated sucessfully',
            'success' => 200,
        ]);
    }
 }
