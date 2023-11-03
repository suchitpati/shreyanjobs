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


    public function __construct($title,$description)
    {
        $this->title = $title;
        $this->description = $description;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('jobEmail')->with(['title'=> $this->title,'description'=> $this->description] )->subject('Job added to shreyanjobs.com. Job Title :' .$this->title);
    }
}
