<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerJobApplication extends Model
{
    use HasFactory;

    protected $table = 'seeker_job_applications';
    protected $fillable = [
        'seeker_id',
        'job_id'
    ];

}
