<?php

namespace App\Jobs;

use App\Mail\ConsultantJobMailToEmployer;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendConsultantJobMailToEmployer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employer_emailid;
    protected $recruiter_emailid;
    protected $job_title;
    protected $consultant_data;
    protected $city;
    protected $country;
    protected $additional_detail;
    protected $detailed_description;
    protected $state;
    protected $remote;
    protected $cover_letter;
    protected $recruiter_name;





    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employer_emailid, $recruiter_emailid, $job_title, $consultant_data, $city, $country, $additional_detail, $detailed_description, $state, $remote, $cover_letter,$recruiter_name)
    {
        $this->employer_emailid = $employer_emailid;
        $this->recruiter_emailid = $recruiter_emailid;
        $this->job_title = $job_title;
        $this->consultant_data = $consultant_data;
        $this->city = $city;
        $this->country = $country;
        $this->additional_detail = $additional_detail;
        $this->detailed_description = $detailed_description;
        $this->state = $state;
        $this->remote = $remote;
        $this->cover_letter = $cover_letter;
        $this->recruiter_name = $recruiter_name;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->employer_emailid)
                ->cc([$this->recruiter_emailid])
                ->send(new ConsultantJobMailToEmployer($this->job_title, $this->consultant_data, $this->city, $this->country, $this->additional_detail, $this->detailed_description, $this->state,  $this->remote, $this->cover_letter,$this->recruiter_name));
            Log::info($this->employer_emailid);
        } catch (Exception $e) {
            dd($e);
        }
    }
}
