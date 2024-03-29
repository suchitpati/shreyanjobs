<?php

namespace App\Jobs;

use App\Mail\JobMail;
use App\Mail\SeekerOtp;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendJobNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   protected $email;
   protected $data;



    public function __construct($email,$data)
    {
        $this->email = $email;
        $this->data = $data;



    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{



                Mail::to($this->email)->send(new JobMail($this->data));
                Log::info("Request Cycle with Queues Ends");

        }
        catch(Exception $e)
        {
            dd($e);
        }


    }
}
