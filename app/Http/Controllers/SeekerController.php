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
use App\Models\consultantas;
use App\Models\EmployerTransactionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

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
        // $skill_details = explode(',', $seeker_data->skill);
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'skill_details' => $skill_details

        ]);
    }
    public function seeker_addskill(Request $request)
    {

        // $seeker = Seeker::find($request->seeker_id);
        // $existingSkills = $seeker->skill;
        // if($existingSkills == null)
        // {
        //     $newSkill = $request->skill;
        // }else
        // {
        //     $newSkill = $existingSkills . ',' . $request->skill;
        // }
        // $seeker->skill = $newSkill;
        // $seeker->save();






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

        // Fetch the seeker details by ID from the request
        // $seeker_details = Seeker::find($request->seeker_id);

        //     $skill_data = explode(',', $seeker_details->skill);

        //     $filteredItems = array_filter($skill_data, function ($item) use ($request) {
        //         return $item !== $request->skill;
        //     });
        //     if($filteredItems == null)
        //     {
        //         $newSkills = '';
        //     }
        //     else
        //     {

        //         $newSkills = implode(',', $filteredItems);
        //     }

        //     if($newSkills == null)
        //     {
        //         $seeker_details->skill = null;

        //     }
        //     else
        //     {

        //         $seeker_details->skill = $newSkills;
        //     }
        //     $seeker_details->save();

        //     $seeker_data = Seeker::where('id',$request->seeker_id)->first();
        Subscription::find($request->skill)->delete();
        return response()->json([
            'message' => 'Skill Deleted successfully',
            'code' => 200,
        ]);
    }
    public function getSeeker(Request $request)
    {

        if ($request->hasAny(['searchInput', 'skill', 'primary_skill_experience', 'secondary_skill_experience', 'country', 'state', 'city', 'relocate', 'work_visa', 'created_at'])) {

            $seekerQuery = new Seeker();
            $consultantasQuery = consultantas::with('getRecruiter');



            if ($request->skill != null) {
                $seekerQuery = $seekerQuery->where(function ($query) use ($request) {
                    $query->where('primary_skill', 'LIKE', '%' . $request->skill . '%')
                        ->orWhere('secondary_skill', 'LIKE', '%' . $request->skill . '%');
                });
                $consultantasQuery = $consultantasQuery->where(function ($query) use ($request) {
                    $query->where('primary_skill', 'LIKE', '%' . $request->skill . '%')
                        ->orWhere('secondary_skill', 'LIKE', '%' . $request->skill . '%');
                });
            }
            if ($request->country != null) {
                $seekerQuery = $seekerQuery->where('country', $request->country);
                $consultantasQuery = $consultantasQuery->where('country', $request->country);
            }

            if ($request->primary_secondary_skill_experience != null) {
                $seekerQuery = $seekerQuery->where(function ($query) use ($request) {
                    $query->where('primary_skill_experience', '>=', $request->primary_secondary_skill_experience)
                        ->orWhere('secondary_skill_experience', '>=', $request->primary_secondary_skill_experience);
                });

                $consultantasQuery = $consultantasQuery->where(function ($query) use ($request) {
                    $query->where('primary_skill_experience', '>=', $request->primary_secondary_skill_experience)
                        ->orWhere('secondary_skill_experience', '>=', $request->primary_secondary_skill_experience);
                });
            }

            if ($request->state != null) {
                $seekerQuery = $seekerQuery->where('state', $request->state);
                $consultantasQuery = $consultantasQuery->where('state', $request->state);
            }
            if ($request->city != null) {
                $seekerQuery = $seekerQuery->where('city', 'like', '%' . $request->city . '%');
                $consultantasQuery = $consultantasQuery->where('city', 'like', '%' . $request->city . '%');
            }

            if ($request->relocate != null) {
                $seekerQuery = $seekerQuery->where('relocate', $request->relocate == 'true' ? 1 : 0);
                $consultantasQuery = $consultantasQuery->where('relocate', $request->relocate == 'true' ? 1 : 0);
            }

            if (($request->candidate_type != null) &&  ($request->candidate_type != 'both') ) {
                if ($request->candidate_type == "independent") {
                    $consultantasQuery = $consultantasQuery->whereRaw('1 = 0');
                }

                if ($request->candidate_type == "consultant") {
                    $seekerQuery = $seekerQuery->whereRaw('1 = 0');
                }
            }

            if ($request->work_visa != null) {
                $seekerQuery = $seekerQuery->where('work_authorization', 'like', '%' . $request->work_visa . '%');
                $consultantasQuery = $consultantasQuery->where('work_authorization', 'like', '%' . $request->work_visa . '%');
            }

            if ($request->last_accessed != null) {
                $seekerQuery = $seekerQuery->where('last_accessed_date', '>', now()->subDays($request->last_accessed)->endOfDay());
            }

            $seekerQuery = $seekerQuery->where('is_active', 2);
            // $consultantasQuery = $consultantasQuery->where('is_active', 1);

            $seekerdetails = $seekerQuery->orderBy('last_accessed_date', 'DESC')->get();
            $consultantasQuery = $consultantasQuery->get();

            $consultantasQuery->each(function ($consultanta) {
                $consultanta->last_accessed_date = $consultanta->getRecruiter->last_accessed_date ?? null;
            });
            $combinedResults = collect();
            $combinedResults = $combinedResults->concat($seekerdetails);
            $combinedResults = $combinedResults->concat($consultantasQuery);

            $seekerdetails = $combinedResults->sortByDesc('last_accessed_date')->values();



            return response()->json([
                'success' => 200,
                'seeker_details' => $seekerdetails
            ]);
        } else {
            return response()->json([
                'success' => 200,
                'seeker_details' => $seekerdetails
            ]);
        }
        // $seekerQuery = new Seeker();

        // if ($request->searchInput != null) {
        //     $seeker_details = Seeker::where(function ($query) use ($request) {
        //         $query->where('fullname', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('primary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('secondary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('state', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('city', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('country', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('skill', 'LIKE', '%' . $request->searchInput . '%');
        //     })
        //         ->where('is_active', 2)
        //         ->get();
        // } else {
        //     $seeker_details = Seeker::where('is_active', 2)->get(['id', 'fullname', 'primary_skill', 'primary_skill_experience', 'secondary_skill', 'secondary_skill_experience', 'city', 'state', 'country', 'relocate', 'work_authorization','skill']);


        // }

        // if ($request->searchInput != null) {
        //     $seekerQuery = $seekerQuery->where(function ($query) use ($request) {
        //         $query->where('fullname', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('primary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('secondary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('state', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('city', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('country', 'LIKE', '%' . $request->searchInput . '%');
        //             // ->orWhere('skill', 'LIKE', '%' . $request->searchInput . '%');
        //     });
        // }


        // if ($request->searchInput != null) {
        //     $seekerQuery = $seekerQuery->where(function ($query) use ($request) {
        //         $query->where('fullname', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('primary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('secondary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('state', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('city', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('country', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('skill', 'LIKE', '%' . $request->searchInput . '%');
        //     });
        // }
        // if ($request->skill != null) {
        //     $seekerQuery = $seekerQuery->where('primary_skill', 'LIKE','%' . $request->skill . '%')
        //                                 ->orWhere('secondary_skill','LIKE', '%' . $request->skill . '%');
        // }

        // if ($request->primary_skill_experience != null) {
        //     $seekerQuery = $seekerQuery->where('primary_skill_experience', '>=', $request->primary_skill_experience);
        // }
        // if ($request->secondary_skill_experience != null) {
        //     $seekerQuery = $seekerQuery->where('secondary_skill_experience', '>=', $request->secondary_skill_experience);
        // }
        // if ($request->country != null) {
        //     $seekerQuery = $seekerQuery->where('country', $request->country);
        // }

        // if ($request->state != null) {
        //     $seekerQuery = $seekerQuery->where('state', $request->state);
        // }

        // if ($request->city != null) {
        //     $seekerQuery = $seekerQuery->where('city', 'like', '%' . $request->city. '%');
        // }

        // $seekerQuery->when($request->has('relocate'), function ($seekerQuery) use ($request) {
        //     $seekerQuery->where('relocate', $request->relocate == true );
        // });

        // if ($request->relocate != null) {
        //     $seekerQuery = $seekerQuery->where('relocate', $request->relocate == 'true' ? 1 : 0);
        // }
        // if ($request->work_visa != null) {
        //     $seekerQuery = $seekerQuery->where('work_authorization', 'like', '%' . $request->work_visa. '%');
        // }

        // if ($request->created_at != null) {

        //     $startDate = Carbon::parse($request->created_at);
        //     $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        //     $seekerQuery = $seekerQuery->where('created_at', '>=', $formattedStartDate)->orderByDesc('created_at');


        // }




        //     $seekerQuery = Seeker::where('is_active', 2);

        // if ($request->has('searchInput') && $request->searchInput != null) {
        //     $seekerQuery->where(function ($query) use ($request) {
        //         $query->where('fullname', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('primary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('secondary_skill', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('state', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('city', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('country', 'LIKE', '%' . $request->searchInput . '%')
        //             ->orWhere('skill', 'LIKE', '%' . $request->searchInput . '%');
        //     });
        // }

        // if ($request->has('skill')) {
        //     $seekerQuery->where('skill', 'like', '%' . $request->skill . '%');
        // }

        // if ($request->has('primary_skill_experience')) {
        //     $seekerQuery->where('primary_skill_experience', $request->primary_skill_experience);
        // }


        // $seekerDetails = $seekerQuery->get([
        //     'id', 'fullname', 'primary_skill', 'primary_skill_experience',
        //     'secondary_skill', 'secondary_skill_experience', 'city',
        //     'state', 'country', 'relocate', 'work_authorization', 'skill'
        // ]);

        // return response()->json([
        //     'success' => 200,
        //     'seeker_details' => $seekerDetails
        // ]);

    }

    public function seekerContactDetail($id, $employe_id)
    {
        $seeker = Seeker::where('id', $id)->get(['email', 'contact_number']);

        $employer = Employer::find($employe_id);
        if ($employer->role != 1) {

            if ($employer->acct_balance < 0.5) {
                return response()->json([
                    'code' => 100,
                    'message' => "Insufficient balance",
                    'status' => 'error'
                ]);
            }
            $begin_balance = $employer->acct_balance;
            $end_balance = $employer->acct_balance - 0.50;

            $employer->acct_balance = $end_balance;
            $employer->save();

            EmployerTransactionHistory::create([
                'employer_id' => $employe_id,
                'begin_balance' => $begin_balance,
                'transaction_amount' => 0.50,
                'end_balance' => $end_balance,
                'transaction_date' => Carbon::now(),
                'action_name' => 'View Contact',
                'job_seeker_id' => $id
            ]);
        }
        return response()->json([
            'message' => 'Details fetch successfully',
            'success' => 200,
            'seeker_details' => $seeker

        ]);
    }
    public function seekerResumeDetail($id, $employe_id)
    {
        $seeker = Seeker::where('id', $id)->get(['resume']);

        $employer = Employer::find($employe_id);
        if ($employer->role != 1) {

            if ($employer->acct_balance < 0.5) {
                return response()->json([
                    'code' => 100,
                    'message' => "Insufficient balance",
                    'status' => 'error'
                ]);
            }
            $begin_balance = $employer->acct_balance;
            $end_balance = $employer->acct_balance - 0.50;

            $employer->acct_balance = $end_balance;
            $employer->save();

            EmployerTransactionHistory::create([
                'employer_id' => $employe_id,
                'begin_balance' => $begin_balance,
                'transaction_amount' => 0.50,
                'end_balance' => $end_balance,
                'transaction_date' => Carbon::now(),
                'action_name' => 'View Resume',
                'job_seeker_id' => $id
            ]);
        }
        // $test = url('/pdf/' . $seeker[0]->resume);
        $filePath = public_path('pdf/' . $seeker[0]->resume);

        if (is_file($filePath)) {
            return response()->json([
                'message' => 'Details fetch successfully',
                'success' => 200,
                'seeker_details' => $seeker,
                'status' => 'exist'

            ]);
        } else {
            return response()->json([
                'message' => 'Details fetch successfully',
                'success' => 200,
                'seeker_details' => $seeker,
                'status' => 'not'

            ]);
        }
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
                'linkedin_url' => $request->linkedin_url,
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
                'linkedin_url' => $request->linkedin_url,
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
                'linkedin_url' => $request->linkedin_url,
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

        // $seeker= Seeker::find($request->seeker_id);
        // $shortFullname = str_replace(' ', '', substr($seeker->fullname, 0, 15));
        // $shortprimary_skill = str_replace(' ', '', substr($seeker->primary_skill, 0, 15));
        // $fileName = "Resume_".$shortFullname.'_'.$shortprimary_skill.'_'.$request->seeker_id. '.' . $request->file('pdf')->getClientOriginalExtension();
        // dd($fileName);
        if ($request->has('pdf')) {

            $allowedExtensions = ['pdf', 'doc', 'docx'];
            // $maxFileSize = 3 * 1024;


            //17-7-2024 change to file name
            // if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
            //     $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
            //     $request->file('pdf')->move(public_path('pdf'), $fileName);
            // } else {
            //     return response()->json([
            //         'message' => 'Only PDF and DOC files are allowed, and the file must be less than 3MB.',
            //         'error' => 100,
            //     ]);
            // }


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
                    'relocate' => $request->relocate,
                    'is_active' => 2
                ]);




            $seeker = Seeker::find($request->seeker_id);
            $shortFullname = str_replace(' ', '', substr($seeker->fullname, 0, 15));
            $shortprimary_skill = str_replace(' ', '', substr($seeker->primary_skill, 0, 15));



            if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
                $fileName = "Resume_" . $shortFullname . '_' . $shortprimary_skill . '_' . $request->seeker_id . '.' . $request->file('pdf')->getClientOriginalExtension();
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
                    'resume' => $fileName,
                ]);
            // Subscription::create([
            //     'skill' => $request->skill,
            //     'seeker_id' => $request->seeker_id
            // ]);


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

            // if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
            //     $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
            //     $request->file('pdf')->move(public_path('pdf'), $fileName);
            // } else {
            //     return response()->json([
            //         'message' => 'Only PDF and DOC files are allowed, and the file must be less than 3MB.',
            //         'error' => 100,
            //     ]);
            // }

            $seeker = Seeker::find($request->seeker_id);
            $shortFullname = str_replace(' ', '', substr($seeker->fullname, 0, 15));
            $shortprimary_skill = str_replace(' ', '', substr($seeker->primary_skill, 0, 15));



            if (in_array($request->file('pdf')->getClientOriginalExtension(), $allowedExtensions)) {
                $fileName = "Resume_" . $shortFullname . '_' . $shortprimary_skill . '_' . $request->seeker_id . '.' . $request->file('pdf')->getClientOriginalExtension();
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
            'linkedin_url' => $request->linkedin_url,
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

        if ($seeker->is_active == 1) {;

            return response()->json([
                'seeker_id' => $seeker->id,
                'message' => 'Your Account Registration did not complete last time. Please re-register the account',
                'is_active' => $seeker->is_active,
                'code' =>  200
            ]);
        }

        if (!$seeker || !Hash::check($request->password, $seeker->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => 100
            ]);
        }
        Seeker::where('email', $request->email)
            ->update(['last_accessed_date' => Date::now()]);
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
    public function applyJobMail(Request $request)
    {

        $employer = Employer::find($request->employer_id);
        $Seeker = Seeker::find($request->seeker_id);

        $adminjob = AdminJob::find($request->id);
        $apply_count = $adminjob->apply_count + 1;
        AdminJob::where('id', $request->id)->update(['apply_count' => $apply_count]);
        $remote = $adminjob->remote;

        $cover_letter = $request->cover_letter;
        if ($cover_letter == null  || $cover_letter == "") {
            $cover_letter = "-";
        }

        if ($request->file('pdf')) {

            $allowedExtensions = ['pdf', 'doc', 'docx'];
            $path = public_path('pdf');
            $fileName = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
            $resume = $request->file('pdf')->move(public_path('pdf'), $fileName);

            $resume->move($path, $fileName);

            $resume_file = $path . '/' . $fileName;
        } else {
            $path = public_path('pdf');

            $resume_file = $path . '/' . $Seeker->resume;
        }

        $job_title = $adminjob->job_title;
        $fullname = $Seeker->fullname;
        $seeker_country = $Seeker->country;
        $seeker_state = $Seeker->state;
        $seeker_city = $Seeker->city;
        $seeker_work_authorization = $Seeker->work_authorization;
        $seeker_linkedin_url = $Seeker->linkedin_url;


        $employername = $employer->employername;
        $emailid = $employer->emailid;
        $city = $adminjob->city;
        $country = $adminjob->country;
        $detailed_description = $adminjob->detailed_description;
        $state = $adminjob->state;
        $additional_detail = $adminjob->additional_detail;
        $email = $Seeker->email;
        $adminemail = $adminjob->email;
        $fileStatus = 1;
        try {
            if ($request->file('pdf')) {
                $fileStatus = 0;
            }

            applyJobEmail::dispatch($fileStatus, $adminemail, $email, $job_title, $fullname, $employername, $city, $country, $additional_detail, $resume_file, $detailed_description, $state, $cover_letter, $emailid, $remote, $seeker_country, $seeker_state, $seeker_city, $seeker_work_authorization, $seeker_linkedin_url);
            // if($request->file('pdf'))
            // {
            //     File::delete($resume_file);
            // }

            SeekerJobApplication::create(['seeker_id' => $request->seeker_id, 'job_id' => $request->id]);
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
