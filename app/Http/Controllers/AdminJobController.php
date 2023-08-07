<?php

namespace App\Http\Controllers;

use App\Models\AdminJob;
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
        $query = AdminJob::query();


        $query->when($request->has('country'), function ($query) use ($request) {
            $query->where('country', $request->country);
        });

        $query->when($request->has('state'), function ($query) use ($request) {
            $query->where('state', $request->state);
        });

        $query->when($request->has('remote'), function ($query) use ($request) {
            // dd($request->remote == 'true');
            $query->where('remote', $request->remote == 'true'? true: false);
        });

        $query->when($request->has('skill'), function ($query) use ($request) {
            $query->where('skill', 'like', '%' . $request->skill . '%');
        });

        $query->when($request->has('year_of_experience'), function ($query) use ($request) {
            $query->where('year_of_experience', $request->year_of_experience);
        });

        $query->when($request->has('search'), function ($query) use ($request) {
            $search = $request->search;

            $query->where('job_title', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%');
        });

        // $query->when($request->has('short_description'), function ($query) use ($request) {
        //     $query->where('short_description', $request->short_description);
        // });

        // $query->when($request->has('job_title'), function ($query) use ($request) {
        //     $query->where('job_title', $request->job_title);
        // });


        $query->when($request->has('detailed_description'), function ($query) use ($request) {
            $query->where('detailed_description', $request->detailed_description);
        });

        $query->when($request->has('employment_type'), function ($query) use ($request) {
            $query->where('employment_type', $request->employment_type);
        });
        $query->when($request->has('created_at'), function ($query) use ($request) {
            $startDate = Carbon::parse($request->created_at);
            $formattedStartDate = $startDate->format('Y-m-d H:i:s');
            $query->where('created_at', '>=', $formattedStartDate)->orderByDesc('created_at');;
        });


        $query->increment('search_count', 1);

        $jobs = $query->get();


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
            'remote' => 'required|boolean',
            'skill' => 'required|string',
            'year_of_experience' => 'required|integer',
            'employment_type' => 'required|string',
            'short_description' => 'required|string',
            'detailed_description' => 'required|string',
            'job_title' => 'required|string'
        ]);

        $job = AdminJob::create($validatedData);
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
