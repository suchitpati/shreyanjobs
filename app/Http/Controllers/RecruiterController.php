<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recruiter;
use App\Mail\RecruiterOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    if (Recruiter::where(['emailid' => $email, 'is_active' => 2])->exists()) {
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
        return response()->json(['message'=>$recruiter]);
        return response()->json([
            'message' => 'Recruiter OTP sent successfully',
            'success' => 200,
            'recruiter_id' => $recruiter->id
        ]);
    }
}
public function validateOtp(Request $request)
{

    if (Recruiter::where(['id' => $request->recruiter_id, 'otp' => $request->otp])->exists()) {
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

 }
