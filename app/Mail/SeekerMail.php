<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeekerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $job_title;
    protected $resume;
    protected $fullname;
    protected $employername;
    protected $city;
    protected $country;
    protected $additional_detail;
    protected $job_title;
    protected $state;
    protected $detailed_description;
    protected  $cover_letter;


    public function __construct($job_title,$fullname,$employername,$city,$country,$additional_detail,$resume,$detailed_description,$state,$cover_letter)
    {
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



    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->view('applyJobEmail')->with(['job_title'=>$this->job_title,'country'=>$this->country,'fullname'=>$this->fullname,'employername'=>$this->employername,'city'=>$this->city,'additional_detail'=>$this->additional_detail,'state'=>$this->state,'detailed_description'=>$this->detailed_description,'cover_letter'=>$this->cover_letter])->attach($this->resume);
    }
}
