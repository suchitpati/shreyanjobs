<?php

namespace App\Http\Controllers;

use App\Jobs\SendJobNotification;
use App\Models\AdminJob;
use App\Models\Employer;
use App\Models\EmployerTransactionHistory;
use App\Models\ProfileCounter;
use App\Models\Seeker;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adminJobs = AdminJob::with('seekerdata');

        $adminJobs->where(function ($query) {
            $query->where(function ($q) {
                $q->where('paid', 0) // Free jobs
                    ->where('created_at', '>=', now()->subDays(2)->startOfDay());
            })->orWhere(function ($q) {
                $q->where('paid', 1) // Paid jobs
                    ->where('created_at', '>=', now()->subDays(7)->startOfDay());
            });
        });

        // $query = AdminJob::orderBy('created_at', 'DESC');
        // $adminJobs = $query->get();


        $adminJobs->when($request->has('country'), function ($adminJobs) use ($request) {
            $adminJobs->where('country', $request->country);
        });

        $adminJobs->when($request->has('state'), function ($adminJobs) use ($request) {
            $adminJobs->where('state', $request->state);
        });

        $adminJobs->when($request->has('remote'), function ($adminJobs) use ($request) {
            $adminJobs->where('remote', $request->remote == 'true' ? true : false);
        });

        $adminJobs->when($request->has('skill'), function ($adminJobs) use ($request) {
            $adminJobs->where('skill', 'like', '%' . $request->skill . '%');
        });

        $adminJobs->when($request->has('year_of_experience'), function ($adminJobs) use ($request) {
            $adminJobs->where('year_of_experience', $request->year_of_experience);
        });

        // $adminJobs->when($request->has('search'), function ($adminJobs) use ($request) {
        //     $search = $request->search;

        //     $adminJobs->where('job_title', 'like', '%' . $search . '%')
        //     ->orWhere('short_description', 'like', '%' . $search . '%');

        // });


        // $adminJobs->when($request->has('search'), function ($adminJobs) use ($request) {
        //     $search = $request->search;
        //     $adminJobs->where('short_description', 'like', '%' . $search . '%');

        // });

        $adminJobs->when($request->has('search'), function ($adminJobs) use ($request) {
            $search = $request->search;
            $adminJobs->where('job_title', 'like', '%' . $search . '%');
        });


        $adminJobs->when($request->has('detailed_description'), function ($adminJobs) use ($request) {
            $adminJobs->where('detailed_description', $request->detailed_description);
        });

        $adminJobs->when($request->has('employment_type'), function ($adminJobs) use ($request) {
            $adminJobs->where('employment_type', $request->employment_type);
        });
        $adminJobs->when($request->has('created_at'), function ($adminJobs) use ($request) {
            $startDate = Carbon::parse($request->created_at);
            $formattedStartDate = $startDate->format('Y-m-d H:i:s');
            $adminJobs->where('created_at', '>=', $formattedStartDate)->orderByDesc('created_at');
        });

        $adminJobs->orderByRaw("CASE WHEN paid = 1 THEN 0 ELSE 1 END");

        // $adminJobs->increment('search_count', 1);
        // $adminJobs->where('created_at', '>', now()->subDays(30)->endOfDay());
        // $adminJobs->where('created_at', '>', now()->subDays(7)->endOfDay());


        $jobs = $adminJobs->orderByDesc('created_at')->get();


        return response()->json($jobs);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'country' => 'required|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'remote' => 'required|boolean',
            'paid' => 'required|boolean',
            'skill' => 'required|string',
            'year_of_experience' => 'required|integer',
            'employment_type' => 'required|string',
            'short_description' => 'required|string',
            'detailed_description' => 'required|string',
            'job_title' => 'required|string',
            'email' => 'nullable|string',
            'contact_number'  => 'nullable|string',
            'additional_detail' => 'nullable|string',
            'technical_skill' => 'nullable|string',
            'job_owner_id' => 'required|integer',
        ]);

        $employer = Employer::find($request->job_owner_id);
        if ($employer->role != 1 && $request->paid == true) {
            if ($employer->acct_balance < 1) {
                return response()->json([
                    'code' => 100,
                    'message' => "Insufficient balance",
                    'status' => 'error'
                ]);
            }
            $begin_balance = $employer->acct_balance;
            $end_balance = $employer->acct_balance - 1;

            $employer->acct_balance = $end_balance;
            $employer->save();
        }

        $job = AdminJob::create($validatedData);



        if ($employer->role != 1 && $request->paid == true) {
            EmployerTransactionHistory::create([
                'employer_id' => $request->job_owner_id,
                'begin_balance' => $begin_balance,
                'transaction_amount' => 1,
                'end_balance' => $end_balance,
                'transaction_date' => Carbon::now(),
                'action_name' => 'Job Posting',
            ]);
        }

        // $job_title = $request->job_title;
        // $detailed_description = $request->detailed_description;
        // $location = $request->city . ',' . $request->state . ',' . $request->country;
        // $duration = $request->employment_type;
        // $skill = $request->skill;
        // $country = $request->country;
        // $additional_detail = "No additional detail";

        // $remote = $request->remote;

        // if (isset($request->additional_detail)) {
        //     $additional_detail = $request->additional_detail;
        // }

        // $searchTerms = explode(' ', $skill);

        // $subscription_data = Subscription::all();
        // $foundSubscriptions = [];

        // foreach ($subscription_data as $sub) {
        //     $found = strpos(strtolower($skill), strtolower($sub->skill)) !== false;
        //     $found1 = strpos(strtolower($job_title), strtolower($sub->skill)) !== false;


        //     if ($found || $found1) {
        //         $foundSubscriptions[] = $sub->seeker_id;
        //     }
        // }

        // $uniqueFoundSubscriptions = array_unique($foundSubscriptions);
        // $subscription_data = Seeker::whereIn('id', $uniqueFoundSubscriptions)->get();
        // if (isset($subscription_data)) {

        //     foreach ($subscription_data as $sub) {

        //         SendJobNotification::dispatch($sub->email, $job_title, $detailed_description, $location, $duration, $skill, $additional_detail, $remote, $country);
        //     }
        // }


        // SendJobNotification::dispatch($subscription_data,$request->job_title);

        return response()->json($job, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = AdminJob::findOrFail($id);
        return response()->json($job);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'country' => 'required|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'remote' => 'required|boolean',
            'skill' => 'required|string',
            'year_of_experience' => 'required|integer',
            'employment_type' => 'required|string',
            'short_description' => 'required|string',
            'detailed_description' => 'required|string',
            'job_title' => 'required|string',
            'email' => 'nullable|string',
            'contact_number'  => 'nullable|string',
            'additional_detail' => 'nullable|string',
            'technical_skill' => 'nullable|string',
        ]);

        $job = AdminJob::findOrFail($id);
        $job->update($validatedData);

        return response()->json($job, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = AdminJob::findOrFail($id);
        $job->delete();

        return response()->json(null, 204);
    }

    public function employerJob($id)
    {
        //24-7-2024 updated
        // $job = AdminJob::where('job_owner_id', $id)->where('created_at', '>', now()->subDays(30)->endOfDay())->latest()->get();
        // return response()->json($job, 200);

        $job = AdminJob::with('seekerdata')->where('job_owner_id', $id);



        $job->where(function ($query) {
            $query->where(function ($q) {
                $q->where('paid', 0) // Free jobs
                    ->where('created_at', '>=', now()->subDays(2)->startOfDay());
            })->orWhere(function ($q) {
                $q->where('paid', 1) // Paid jobs
                    ->where('created_at', '>=', now()->subDays(7)->startOfDay());
            });
        });
        $job = $job->orderByDesc('created_at')->get();

        return response()->json($job, 200);

    }

    public function totalData()
    {
        $total_seeker = ProfileCounter::where('profile_type', 'job_seekers')->select('profle_count','display_profile_type')->first();

        $total_employer = ProfileCounter::where('profile_type', 'employers_recruiters')->select('profle_count','display_profile_type')->first();
        $total_bench_sales_recruiters = ProfileCounter::where('profile_type', 'bench_sales_recruiters')->select('profle_count','display_profile_type')->first();

        return response()->json([
            'success' => 200,
            'total_seeker' => $total_seeker->profle_count,
            'seeker_display_profile_type' => $total_seeker->display_profile_type,
            'employer_display_profile_type' => $total_employer->display_profile_type,
            'recruiters_display_profile_type' => $total_bench_sales_recruiters->display_profile_type,
            'total_employer' => $total_employer->profle_count,
            'total_bench_sales_recruiters' => $total_bench_sales_recruiters->profle_count,
        ]);
    }
}
