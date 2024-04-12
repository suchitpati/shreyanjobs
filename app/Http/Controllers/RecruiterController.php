<?php

namespace App\Http\Controllers;

use App\Jobs\SendConsultantJobMailToEmployer;
use App\Mail\RecruiterMail;
use Illuminate\Http\Request;
use App\Models\Recruiter;
use App\Mail\RecruiterOtpMail;
use App\Models\AdminJob;
use App\Models\consultantas;
use App\Models\Employer;
use App\Models\Seeker;
use Carbon\Carbon;
use Exception;
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

        if (Recruiter::where(['emailid' => $email])->exists()) {
            return response()->json([
                'message' => 'Account Already exist',
                'error' => 100
            ]);
        }
        else {
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
        $recruiter = Recruiter::where('id', $request->recruiter_id)->first();
        if ($recruiter->otp == $request->otp) {
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

    public function loginrecruiter(Request $request)
    {
        $recruiter = Recruiter::where(['emailid' => $request->email])->first();
        // return response()->json(['emailid' => $request->email]);
        if ($recruiter == null || $recruiter == '') {
            return response()->json([
                'message' => 'Email not found',
                'code' => 100
            ]);
        }

        if (!$recruiter || !Hash::check($request->password, $recruiter->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => 100
            ]);
        }
        if ($recruiter->is_active == 0) {
            $email = $request->email;
            $otp = rand(100000, 999999);

            $maildata = [
                'title' => 'Varification OTP',
                'body' => 'Your OTP is ' . $otp,
            ];
            Mail::to($email)->send(new RecruiterOtpMail($maildata));

            Recruiter::where('emailid', $email)->update([
                'otp' => $otp,
            ]);


            return response()->json([
                'message' => 'Your Account Registration did not complete last time. Please re-register the account',
                'code' => 401,
                'recruiter_id' => $recruiter->id,

            ]);
        }
        $token = $recruiter->createToken('RecruiterToken')->plainTextToken;
        // return response()->json(['token'=>$token]);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'recruiter_id' => $recruiter->id,
            'role' => $recruiter->role,
        ], 200);
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


    public function recruiterLogout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->where('name', 'RecruiterToken')->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function recruiterDetails(Request $request)
    {
        $id = $request->id;
        $recruiter =  Recruiter::find($id);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'recruiter_details' => $recruiter
        ]);
    }
    public function recruiterDetailsByConsultants(Request $request)
    {
        $id = $request->recruiter_id;
        $consultantas =  consultantas::where('recruiter_id', $id)->get();
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'consultantas_details' => $consultantas
        ]);
    }
    public function activeConsultantsData(Request $request)
    {
        $id = $request->recruiter_id;
        $consultantas =  consultantas::where('recruiter_id', $id)->where('is_active',1)->get();
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'consultantas_details' => $consultantas
        ]);
    }


    public function recruiterUpdate(Request $request)
    {
        $id = $request->recruiter_id;
        $recruiter = Recruiter::where('id', $id)->update([
            'fullname' => $request->fullname,
            'contactno' => $request->contactno,
            'companyname' => $request->companyname,
            'companyurl' => $request->companyurl,
            'is_active' => 0,
        ]);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'recruiter_details' => $recruiter
        ]);
    }

    public function consultantsJobApply(Request $request)
    {
        $consultantasIds = $request->consultant_ids;
        $job_id = $request->job_id;
        $recruiter_id = $request->recruiter_id;

        $job_details = AdminJob::where('id', $job_id)->first();
        $job_title = $job_details->job_title;
        $city = $job_details->city;
        $country = $job_details->country;
        $detailed_description = $job_details->detailed_description;
        $state = $job_details->state;
        $additional_detail = $job_details->additional_detail;
        $remote = $job_details->remote;


        $cover_letter = $request->consultants_cover_letter;
        if ($cover_letter == null  || $cover_letter == "") {
            $cover_letter = "-";
        }


        $employer = Employer::find($job_details->job_owner_id);
        $employer_emailid =  $employer->emailid;
        $employername = $employer->employername;


        $recruiter_details = Recruiter::where('id', $recruiter_id)->first();
        $recruiter_emailid =  $recruiter_details->emailid;
        $recruiter_name =  $recruiter_details->fullname;




        $consultant_data = consultantas::whereIn('id', $consultantasIds)->get();
        try {
            SendConsultantJobMailToEmployer::dispatch($employer_emailid, $recruiter_emailid, $job_title, $consultant_data, $employername, $city, $country, $additional_detail, $detailed_description, $state, $remote, $cover_letter, $recruiter_name);
        } catch (Exception $e) {
            dd($e);
        }


        $cover_letter = $request->cover_letter;
        if ($cover_letter == null  || $cover_letter == "") {
            $cover_letter = "-";
        }

        return response()->json([
            'message' => 'Job Apply susscessfully',
            'success' => 200,
            'recruiter_details' => $recruiter_details
        ]);
    }

    public function updatePassword(Request $request)
    {
        if (Recruiter::where(['id' => $request->recruiter_id])->exists()) {
        }
        Recruiter::where('id', $request->recruiter_id)
            ->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'password updated sucessfully',
            'success' => $request->all(),
        ]);
    }
}
