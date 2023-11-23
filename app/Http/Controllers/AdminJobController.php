<?php

namespace App\Http\Controllers;

use App\Jobs\SendJobNotification;
use App\Models\AdminJob;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adminJobs= AdminJob::query();

        // $query = AdminJob::orderBy('created_at', 'DESC');
        // $adminJobs = $query->get();


        $adminJobs->when($request->has('country'), function ($adminJobs) use ($request) {
            $adminJobs->where('country', $request->country);
        });

        $adminJobs->when($request->has('state'), function ($adminJobs) use ($request) {
            $adminJobs->where('state', $request->state);
        });

        $adminJobs->when($request->has('remote'), function ($adminJobs) use ($request) {
            $adminJobs->where('remote', $request->remote == 'true'? true: false);
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


        $adminJobs->increment('search_count', 1);
        $adminJobs->where('created_at', '>', now()->subDays(60)->endOfDay());

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
        $job_title = $request->job_title;
        $detailed_description = $request->detailed_description;
        $location = $request->country;
        $duration = $request->employment_type;

        $job = AdminJob::create($validatedData);

        $subscription_data = Subscription::with('seeker')
                ->where('skill','LIKE','%'.$request->skill.'%')
                ->orWhere('skill','LIKE','%'.$request->job_title.'%')
                ->get();
        if(isset($subscription_data))
        {

            foreach($subscription_data as $sub)
            {

                SendJobNotification::dispatch($sub->seeker->email,$job_title,$detailed_description,$location,$duration);
            }
        }

            // SendJobNotification::dispatch($subscription_data,$request->job_title);

        return response()->json($subscription_data, 201);
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
            'remote' => 'required|boolean',
            'skill' => 'required|string',
            'year_of_experience' => 'required|integer',
            'employment_type' => 'required|string',
            'short_description' => 'required|string',
            'detailed_description' => 'required|string',
            'job_title' => 'required|string'

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
}
