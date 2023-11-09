<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Seeker extends Model
{
    use HasFactory,HasApiTokens;

    protected $guard = 'seeker';

    protected $table = "seekers";

    protected $fillable = ['fullname', 'email', 'password', 'gender', 'is_active', 'otp'];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}



