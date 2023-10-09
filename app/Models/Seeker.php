<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;

    protected $table = "seekers";

    protected $fillable = ['fullname','email','password','gender','is_active','otp'];
}
