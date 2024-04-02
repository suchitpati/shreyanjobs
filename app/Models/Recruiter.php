<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    use HasFactory;
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
