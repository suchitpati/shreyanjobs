<?php

namespace App\Jobs;


use Illuminate\Support\Facades\File;
use App\Mail\SeekerMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class applyJobEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $resume;
    protected $fullname;
    protected $employername;
    protected $city;
    protected $country;
    protected $additional_detail;
    protected $job_title;
    protected $state;
    protected $detailed_description;
    protected $cover_letter;
    protected $emailid;
    protected $remote;
    protected $email;
    protected $adminemail;
    protected $fileStatus;

    public function __construct($fileStatus,$adminemail,$email,$job_title,$fullname,$employername,$city,$country,$additional_detail,$resume,$detailed_description,$state,$cover_letter,$emailid,$remote)
    {
        Log::info('Email sent successfully.');
        $this->job_title = $job_title;
        $this->resume = $resume;
        $this->detailed_description = $detailed_description;
        $this->fullname = $fullname;
        $this->employername = $employername;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->additional_detail = $additional_detail;
        $this->cover_letter =  $cover_letter;
        $this->emailid = $emailid;
        $this->remote = $remote;
        $this->email = $email;
        $this->adminemail = $adminemail;
        $this->fileStatus = $fileStatus;





    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        {
            try{
                Mail::to($this->adminemail)->send(new SeekerMail($this->adminemail,$this->email,$this->job_title,$this->fullname,$this->employername,$this->city,$this->country,$this->additional_detail,$this->resume,$this->detailed_description,$this->state,$this->cover_letter,$this->emailid,$this->remote,));

                $fileStatus = $this->fileStatus;
                $resume = $this->resume;
                if($fileStatus == 0)
                {

                    File::delete($resume);
                }

            }
            catch(Exception $e)
            {
                Log::error('Error sending email: ' . $e->getMessage());
                dd($e);
            }

        }
    }

}

