<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultantJobMailToEmployer extends Mailable
{
    use Queueable, SerializesModels;


    protected $job_title;
    protected $consultant_data;
    protected $employername;
    protected $city;
    protected $country;
    protected $additional_detail;
    protected $detailed_description;
    protected $state;
    protected $remote;
    protected $cover_letter;
    protected $recruiter_name;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job_title, $consultant_data, $city, $country, $additional_detail, $detailed_description, $state, $remote, $cover_letter,$recruiter_name)
    {

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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Job Application for {$this->job_title} - From shreyanjobs.com";
        // return $this->view('consultantJobMailToEmployer')->with(['job_title'=>$this->job_title, 'consultant_data' => $this->consultant_data,'country'=>$this->country,'employername'=>$this->employername,'city'=>$this->city,'additional_detail'=>$this->additional_detail,'state'=>$this->state,'detailed_description'=>$this->detailed_description,'cover_letter'=>$this->cover_letter,'remote'=>$this->remote,'recruiter_name' => $this->recruiter_name])->subject($subject);

        $mail = $this->view('consultantJobMailToEmployer')->with([
            'job_title' => $this->job_title,
            'consultant_data' => $this->consultant_data,
            'country' => $this->country,
            'city' => $this->city,
            'additional_detail' => $this->additional_detail,
            'state' => $this->state,
            'detailed_description' => $this->detailed_description,
            'cover_letter' => $this->cover_letter,
            'remote' => $this->remote,
            'recruiter_name' => $this->recruiter_name
        ])->subject($subject);

        $path = public_path('pdf');

        foreach ($this->consultant_data as $consultant) {
            $resume_file = $path . '/' . $consultant['resume']; // Adjust according to your data structure
            $mail->attach($resume_file);
        }

        return $mail;

    }
}
