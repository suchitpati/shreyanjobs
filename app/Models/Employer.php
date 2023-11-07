<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employer extends Model
{
     use HasApiTokens, HasFactory;

    protected $table = 'employer';
    protected $fillable = [
        'companyname',
        'companyurl',
        'employername',
        'emailid',
        'password',
        'confirmpassword',
        'contactno',
        'country',
        'state',
        'city',
        'otp',
        'is_active'
    ];
}
