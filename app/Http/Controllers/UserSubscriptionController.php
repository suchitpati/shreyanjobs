<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserSubscriptionController extends Controller
{
    public function sendOtp(Request $request)
    {
        $email = $request->email;
        $otp = rand(100000,999999);
        // $mailData = [
        //     'Title' => "OTP varifiacation",
        //     'Body' => "YOur OTP number is"
        // ];
        try{
            Mail::to($email)->send(new OtpMail($otp));

           $subscription = Subscription::create([
                'email' => $email,
                'skill' => $request->skill,
                'otp' => $otp,
                'status' => 0
            ]);
            return response()->json([
                'message' => 'Subscription added success fully',
                'subscription_data' => $subscription
            ], 200);

        }catch(Exception $e)
        {
            return response()->json(['message' => 'Mail not send'], 100);

        }

    }
    public function addSubscriber(Request $request)
    {
        $subscription_id = $request->subscription_id;

        $subscription = Subscription::where([
            'otp' => $request->otp,
            'id' => $subscription_id
            ])->first();

        if($subscription)
        {
            Subscription::where('id',$subscription_id)->update(['status' => 1]);
            return response()->json([
                    'message' => 'Subscription added success fully',
                    'success' => 200
                ]);
        }
        else
        {
            return response()->json([
                    'message' => 'Your OTP is wrong',
                    'error' => 100
                ]);

        }


    }
}
