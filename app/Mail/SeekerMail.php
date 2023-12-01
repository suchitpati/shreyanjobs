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
    protected $job_title;
    protected $resume;
    protected $fullname;
    protected $employername;
    protected $city;
    protected $state;
    protected $country;

    public function __construct($job_title,$resume,$fullname,$employername,$city,$state,$country)
    {
        $this->job_title = $job_title;
        $this->resume = $resume;
        $this->fullname = $fullname;
        $this->employername = $employername;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('applyJobEmail')->with(['job_title'=> $this->job_title,'country'=>$this->country,'fullname'=>$this->fullname,'employername'=>$this->employername,'city'=>$this->city])->attach($this->resume);
    }
}
