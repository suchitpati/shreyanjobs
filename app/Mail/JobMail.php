<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $title;
    protected $description;
    protected $location;
    protected $duration;
    protected $skill;
    protected $additional_detail;

    public function __construct($title,$description,$location,$duration,$skill,$additional_detail)
    {
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->duration = $duration;
        $this->skill = $skill;
        $this->additional_detail = $additional_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('jobEmail')->with(['title'=> $this->title,'description'=> $this->description,'location' => $this->location,'duration' => $this->duration,'skill' => $this->skill,'additional_detail' => $this->additional_detail] )->subject($this->title.':New Job Notification from shreyanjobs.com');
    }
}
