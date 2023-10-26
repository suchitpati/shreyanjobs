<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

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
    ];
}
