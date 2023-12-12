<?php

namespace App\Http\Controllers;

use App\Mail\SeekerOtp;
use App\Mail\SeekerOtpMail;
use App\Models\Employer;
use App\Models\Seeker;
use App\Models\AdminJob;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SeekerMail;
use App\Models\SeekerJobApplication;
use App\Models\UserJobApplication;
use Illuminate\Support\Facades\File;
use App\Jobs\applyJobEmail;
use Illuminate\Support\Facades\Log;
use Exception;

class SeekerController extends Controller
{

    public function seeker_profile(Request $request)
    {
        $seeker = Seeker::find($request->seeker_id);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'seeker_details' => $seeker

        ]);
    }
    public function seeker_skill(Request $request)
    {
        $skill_details = Subscription::where('seeker_id', $request->seeker_id)->get();
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'skill_details' => $skill_details

        ]);
    }
    public function seeker_addskill(Request $request)
    {
        if (!Subscription::where(['seeker_id' => $request->seeker_id, 'skill' => $request->skill])->exists()) {
            $seeker = Subscription::create([
                'seeker_id' => $request->seeker_id,
                'skill' => $request->skill,
            ]);

            return response()->json([
                'message' => 'Skill added successfully',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'Skill Already Exist   ',
                'code' => 100,
            ]);
        }
    }

    public function seeker_deleteskill(Request $request)
    {

        Subscription::where([
            'id' => $request->id,
        ])->delete();

        return response()->json([
            'message' => 'Skill Deleted successfully',
            'code' => 200,
        ]);
    }
    public function getSeeker(Request $request)
    {
        if ($request->searchInput != null) {
            $seeker_details = Seeker::where(function ($query) use ($request) {
                $query->where('fullname', 'LIKE', '%' . $request->searchInput . '%')
                    ->orWhere('primary_skill', 'LIKE', '%' . $request->searchInput . '%')
                    ->orWhere('secondary_skill', 'LIKE', '%' . $request->searchInput . '%')
                    ->orWhere('state', 'LIKE', '%' . $request->searchInput . '%')
                    ->orWhere('city', 'LIKE', '%' . $request->searchInput . '%')
                    ->orWhere('country', 'LIKE', '%' . $request->searchInput . '%');
            })
                ->where('is_active', 2)
                ->get();
        } else {
            $seeker_details = Seeker::where('is_active', 2)->get();
        }

        return response()->json([
            'success' => 200,
            'seeker_details' => $seeker_details
        ]);
    }

    public function updatePassword(Request $request)
    {
        if (Seeker::where(['id' => $request->seeker_id])->exists()) {
        }
        Seeker::where('id', $request->seeker_id)
            ->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'password updated sucessfully',
            'success' => $request->all(),
        ]);
    }

    public function registerSeeker(Request $request)
    {
        $email = $request->email;
        $otp = rand(100000, 999999);

        if (Seeker::where(['email' => $request->email, 'is_active' => 2])->exists()) {

            return response()->json([
                'message' => 'Account Already exist',
                'error' => 100
            ]);
        } elseif (Seeker::where(['email' => $request->email, 'is_active' => 0])->exists()) {
            Mail::to($email)->send(new SeekerOtp($otp));


            Seeker::where('email', $request->email)->update([
                'fullname' => $request->fullname,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'is_active' => 0,
                'otp' => $otp
            ]);
            $seeker_details =   Seeker::where('email', $request->email)->first();
            return response()->json([
                'message' => 'Seeker OTP send successfully',
                'success' => 200,
                'seeker_id' => $seeker_details->id
            ]);
        } elseif (Seeker::where(['email' => $request->email, 'is_active' => 1])->exists()) {
            Mail::to($email)->send(new SeekerOtp($otp));


            Seeker::where('email', $request->email)->update([
                'fullname' => $request->fullname,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'is_active' => 0,
                'otp' => $otp
            ]);
            $seeker_details =   Seeker::where('email', $request->email)->first();
            return response()->json([
                'message' => 'Seeker OTP send successfully',
                'success' => 200,
                'seeker_id' => $seeker_details->id
            ]);
        } else {
            Mail::to($email)->send(new SeekerOtp($otp));

            $seeker_details = Seeker::create([
                'fullname' => $request->fullname,
                'email' => $email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'is_active' => 0,
                'relocate' => $request->relocate,
                'otp' => $otp
            ]);
            return response()->json([
                'message' => 'Seeker OTP send successfully',
                'success' => 200,
                'seeker_id' => $seeker_details->id
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
        if ($request->has('pdf')) {

            $allowedExtensions = ['pdf', 'doc', 'docx'];
            // $maxFileSize = 3 * 1024;

            if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
                $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $request->file('pdf')->move(public_path('pdf'), $fileName);
            } else {
                return response()->json([
                    'message' => 'Only PDF and DOC files are allowed, and the file must be less than 3MB.',
                    'error' => 100,
                ]);
            }



            // $fileName = time() . '.' . $request->file('pdf')->extension();
            // $request->file('pdf')->move(public_path('pdf'), $fileName);

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
                    'resume' => $fileName,
                    'relocate' => $request->relocate,
                    'is_active' => 2
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

    public function sendForgotEmailOtp(Request $request)
    {
        $otp = rand(100000, 999999);

        $maildata = [
            'title' => 'mail from Shreyanjobs',
            'body' => 'Your otp for forgot password is ' . $otp,
        ];

        if (Seeker::where(['email' => $request->email])->exists()) {
            Seeker::where(['email' => $request->email])
                ->update(['otp' => $otp]);
            Mail::to($request->email)->send(new SeekerOtpMail($maildata));


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
        if (Seeker::where(['email' => $request->seeker_email, 'otp' => $request->otp])->exists()) {
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
        Seeker::where('email', $request->seeker_email)
            ->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'password updated sucessfully',
            'success' => 200,
        ]);
    }

    public function updateseeker_profile(Request $request)
    {


        $allowedExtensions = ['pdf', 'doc', 'docx'];
        // $maxFileSize = 3 * 1024;
        if ($request->hasFile('pdf')) {

            if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
                $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $request->file('pdf')->move(public_path('pdf'), $fileName);
            } else {
                return response()->json([
                    'message' => 'Only PDF and DOC files are allowed, and the file must be less than 3MB.',
                    'error' => 100,
                ]);
            }
        } else {
            $fileName = $request->resume;
        }

        // $fileName = time() . '.' . $request->file('pdf');
        // if ($request->hasFile('pdf')) {
        //     $fileName = time() . '.' . $request->file('pdf')->extension();
        //     $request->file('pdf')->move(public_path('pdf'), $fileName);
        // } else {
        //     $fileName = $request->resume;
        // }



        Seeker::where('id', $request->seeker_id)->update([
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'contact_number' => $request->contactno,
            'work_authorization' => $request->work_authorization,
            'total_experience' => $request->total_experience,
            'primary_skill' => $request->primary_skill,
            'primary_skill_experience' => $request->primary_skill_experience,
            'secondary_skill' => $request->secondary_skill,
            'secondary_skill_experience' => $request->secondary_skill_experience,
            'relocate' => $request->relocate,
            'gender' => $request->gender,
            'resume' =>  $fileName,
        ]);

        return response()->json([
            'message' => 'Details added successfully',
            'success' => 200,
        ]);
    }

    public function loginSeeker(Request $request)
    {

        $seeker = Seeker::where('email', $request->email)->first();

        if ($seeker == null) {
            return response()->json([
                'message' => 'Email Id not found',
                'code' =>  100
            ]);
        }

        if ($seeker->is_active == 0) {
            return response()->json([
                'message' => 'Your Account Registration did not complete last time. Please re-register the account',
                'code' =>  100
            ]);
        }

        if ($seeker->is_active == 1) {
            return response()->json([
                'message' => 'Your Account Registration did not complete last time. Please re-register the account',
                'code' =>  100
            ]);
        }

        if (!$seeker || !Hash::check($request->password, $seeker->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => 100
            ]);
        }
        $token = $seeker->createToken('SeekerToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'seeker_id' => $seeker->id
        ], 200);



        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        // if (Auth::guard('seeker')->attempt(['email' => $request->email, 'password'  => $request->password])) {

        //     return response()->json([
        //         'message' => 'Login successfull',
        //         'success' => 200,
        //     ]);
        // }
        // return response()->json([
        //     'message' => 'Please try agian letter',
        //     'success' => 100,
        // ]);
    }

    public function seekerLogout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->where('name', 'SeekerToken')->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    public function applyJobMail(Request $request){

        $employer = Employer::find($request->employer_id);
        $Seeker = Seeker::find($request->seeker_id);
        $adminjob = AdminJob::find($request->id);
        $remote = $adminjob->remote;

        $cover_letter = $request->cover_letter;
        if($cover_letter == null  || $cover_letter == "")
        {
            $cover_letter = "-";
        }

        if($request->file('pdf'))
        {

            $allowedExtensions = ['pdf', 'doc', 'docx'];
            $path = public_path('pdf');
            $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
            $resume = $request->file('pdf')->move(public_path('pdf'), $fileName);

            $resume->move($path, $fileName);

            $resume_file = $path . '/' . $fileName;
        }
        else
        {
            $path = public_path('pdf');

            $resume_file = $path . '/' . $Seeker->resume;

        }

        $job_title = $adminjob->job_title;
        $fullname = $Seeker->fullname;
        $employername = $employer->employername;
        $emailid = $employer->emailid;
        $city = $adminjob->city;
        $country = $adminjob->country;
        $detailed_description = $adminjob->detailed_description;
        $state = $adminjob->state;
        $additional_detail = $adminjob->additional_detail;
        $email = $Seeker->email;
        $adminemail = $adminjob->email;
        try {

            applyJobEmail::dispatch($adminemail,$email,$job_title,$fullname, $employername, $city, $country, $additional_detail,$resume_file,$detailed_description,$state, $cover_letter,$emailid,$remote);
            if($request->file('pdf'))
            {
                File::delete($resume_file);
            }

            SeekerJobApplication::create(['seeker_id' => $request->seeker_id,'job_id'=>$request->id]);
            return response()->json([
                'message' => 'Email send successfully',
            ]);
        } catch (Exception $e) {
            Log::error('Error in applying for job: ' . $e->getMessage());
            return response()->json([
                'message' => 'Please try agian letter',
                'error' => $e,
            ]);
        }
    }
}
