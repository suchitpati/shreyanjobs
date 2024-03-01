<?php

namespace App\Http\Controllers;

use App\Jobs\SendJobNotification;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Mail\EmployerOtpMail;
use App\Models\AdminJob;
use App\Models\Seeker;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployerController extends Controller
{
    public function employe_register(Request $request)
    {
        $otp = rand(100000, 999999);

        $maildata = [
            'title' => 'Varification OTP',
            'body' => 'Your OTP is ' . $otp,
        ];

        if (Employer::where(['emailid' => $request->email, 'is_active' => 1])->exists()) {

            return response()->json([
                'message' => 'Account Already exist',
                'error' => 100
            ]);
        } elseif (Employer::where(['emailid' => $request->email, 'is_active' => 0])->exists()) {
            Mail::to($request->email)->send(new EmployerOtpMail($maildata));


            Employer::where('emailid', $request->email)->update([
                'companyname' => $request->companyname,
                'companyurl' => $request->companywebsite,
                'employername' => $request->employername,
                'password' => Hash::make($request->password),
                'contactno' => $request->contact_no,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'otp' => $otp,
                'is_active' => 0,
                'acct_balance' => 50

            ]);

            $employer = Employer::where('emailid', $request->email)->first();

            return response()->json([
                'message' => 'Details added successfully',
                'success' => 200,
                'employer_id' => $employer->id

            ]);
        } else {


            Mail::to($request->email)->send(new EmployerOtpMail($maildata));

            $employer = Employer::create([
                'companyname' => $request->companyname,
                'companyurl' => $request->companywebsite,
                'employername' => $request->employername,
                'emailid' => $request->email,
                'password' => Hash::make($request->password),
                'contactno' => $request->contact_no,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'otp' => $otp,
                'is_active' => 0,
                'acct_balance' => 50
            ]);

            return response()->json([
                'message' => 'Details added successfully',
                'success' => 200,
                'employer_id' => $employer->id

            ]);
        }
    }

    public function employe_profile(Request $request)
    {
        $employer = Employer::find($request->employer_id);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'employer_details' => $employer

        ]);
    }
    public function sendForgotEmailOtp(Request $request)
    {
        $otp = rand(100000, 999999);

        $maildata = [
            'title' => 'mail from Shreyanjobs',
            'body' => 'Your otp for forgot password is' . $otp,
        ];

        if (Employer::where(['emailid' => $request->email])->exists()) {
            Employer::where(['emailid' => $request->email])
                ->update(['otp' => $otp]);
            Mail::to($request->email)->send(new EmployerOtpMail($maildata));


            return response()->json([
                'message' => 'Otp send sucessfully',
                'success' => 200,
                'email' => $request->email

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
        if (Employer::where(['emailid' => $request->employer_email, 'otp' => $request->otp])->exists()) {
            return response()->json([
                'message' => 'Otp verified sucessfully',
                'success' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'please enter valid creadiantials',
                'error' => 100,
            ]);
        }
    }

    public function updateForgotPassword(Request $request)
    {
        if (Employer::where(['emailid' => $request->employer_email])->exists()) {
            Employer::where('emailid', $request->employer_email)
                ->update(['password' => Hash::make($request->password)]);
            return response()->json([
                'message' => 'password updated sucessfully',
                'success' => 200,
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        if (Employer::where(['id' => $request->employer_id])->exists()) {
            Employer::where('id', $request->employer_id)
                ->update(['password' => Hash::make($request->password)]);
            return response()->json([
                'message' => 'password updated sucessfully',
                'success' => 200,
            ]);
        }
    }

    public function admintask()
    {
        $job = AdminJob::where('email_send_status', 0)->get();
        return response()->json([
            'JobDetails' => $job,
            'success' => 200,
        ]);
    }

    // public function sendJobEmailNotification(Request $request)
    // {
    //     $job = AdminJob::where('id', $request->id)->first();
    //     $skill = $job->skill;
    //     $job_title = $job->job_title;
    //     $detailed_description = $job->detailed_description;
    //     $location = $job->city . ',' . $job->state . ',' . $job->country;
    //     $duration = $job->employment_type;
    //     $country = $job->country;
    //     $additional_detail = "No additional detail";

    //     $remote = $job->remote;

    //     if (isset($job->additional_detail)) {
    //         $additional_detail = $job->additional_detail;
    //     }

    //     $subscription_data = Subscription::all();
    //     $foundSubscriptions = [];

    //     foreach ($subscription_data as $sub) {
    //         $found = strpos(strtolower($skill), strtolower($sub->skill)) !== false;
    //         $found1 = strpos(strtolower($job_title), strtolower($sub->skill)) !== false;


    //         if ($found || $found1) {
    //             $foundSubscriptions[] = $sub->seeker_id;
    //         }
    //     }

    //     $uniqueFoundSubscriptions = array_unique($foundSubscriptions);
    //     $subscription_data = Seeker::whereIn('id', $uniqueFoundSubscriptions)->get();
    //     if (isset($subscription_data)) {

    //         foreach ($subscription_data as $sub) {

    //             SendJobNotification::dispatch($sub->email, $job_title, $detailed_description, $location, $duration, $skill, $additional_detail, $remote, $country);
    //         }
    //     }
    //     AdminJob::where('id', $request->id)
    //         ->update(['email_send_status' => 1]);
    //     return response()->json([
    //         'JobDetails' => $job,
    //         'success' => 200,
    //     ]);
    // }


    public function sendJobEmailNotification(Request $request)
    {
        $AdminJob = AdminJob::where('created_at', '>=', Carbon::now()->subDay())->get();
        $seekers = Seeker::with('subscription')->get();
        $foundSubscriptions = [];

        foreach ($seekers as $seeker) {
            $seekerSubscriptions = array_map('strtolower', $seeker->subscription->pluck('skill')->toArray());
            $matchedJobIds = [];

            foreach ($AdminJob as $job) {
                $jobSkills = strtolower($job->skill);

                $matchingSubscriptions = array_filter($seekerSubscriptions, function ($subscriptionSkill) use ($jobSkills) {
                    return strpos($jobSkills, $subscriptionSkill) !== false;
                });

                if (!empty($matchingSubscriptions)) {
                    $matchedJobIds[] = $job->id;
                }
            }

            if (!empty($matchedJobIds)) {
                $foundSubscriptions[] = [
                    'seeker_id' => $seeker->id,
                    'job_id' => $matchedJobIds,
                ];

                $matchedJobs = AdminJob::whereIn('id', $matchedJobIds)->get();

                SendJobNotification::dispatch($seeker->email, $matchedJobs);
            }
        }

        return response()->json([
            'JobDetails' => array_map('unserialize', array_unique(array_map('serialize', $foundSubscriptions))),
            'success' => 200,
        ]);
    }


    public function verifyRegisterOtp(Request $request)
    {


        if (Employer::where(['otp' => $request->otp])->exists()) {
            Employer::where('id', $request->employer_id)
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

    public function updateemployer_profile(Request $request)
    {
        Employer::where('id', $request->employer_id)->update([
            'employername' => $request->employername,
            'contactno' => $request->contactno,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
        ]);

        return response()->json([
            'message' => 'Details added successfully',
            'success' => 200,
        ]);
    }
    public function login(Request $request)
    {

        $employer = Employer::where(['emailid' => $request->email])->first();

        if ($employer == null || $employer == '') {
            return response()->json([
                'message' => 'Email not found',
                'code' => 100
            ]);
        }
        if ($employer->is_active == 0) {
            return response()->json([
                'message' => 'Your Account Registration did not complete last time. Please re-register the account',
                'code' => 100
            ]);
        }
        if (!$employer || !Hash::check($request->password, $employer->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => 100
            ]);
        }

        $token = $employer->createToken('EmployerToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'employer_id' => $employer->id,
            'role' => $employer->role,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->where('name', 'EmployerToken')->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
