<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Recruiter extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = 'recruiters';
    protected $fillable = [
        'fullname',
        'emailid',
        'contactno',
        'password',
        'companyname',
        'companyurl',
        'last_login_date',
        'is_active',
        'otp',
    ];
}
