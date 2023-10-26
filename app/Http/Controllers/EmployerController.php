<?php

namespace App\Http\Controllers;

use App\Mail\EmployerOtpMail;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmployerController extends Controller
{
    public function employe_register(Request $request)
    {

        $otp = rand(100000, 999999);

        $maildata = [
            'title' => 'mail from webappfix',
            'body' => 'Your email is' . $otp,
        ];

        Mail::to($request->emailid)->send(new EmployerOtpMail($maildata));

        Employer::create([
            'companyname' => $request->companyname,
            'companyurl' => $request->companyurl,
            'employername' => $request->employername,
            'emailid' => $request->emailid,
            'password' => $request->password,
            'confirmpassword' => $request->confirmpassword,
            'contactno' => $request->contactno,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'otp' => $otp,
        ]);

        return response()->json([
            'message' => 'Details added successfully',
            'success' => 200,
        ]);
    }

    public function verifyotp(Request $request)
    {

        if (employer::where(['otp' => $request->otp])->exists()) {

            return response()->json([
                'message' => 'Otp verified sucessfully',
                'success' => 200,
            ]);
        }
        elseif (employer::where(['otp' => ''])) {
            return response()->json([
                'message' => 'please enter valid otp',
                'error' => 100,
            ]);
        }
    }
}
