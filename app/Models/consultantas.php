<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultantas extends Model
{
    use HasFactory;
    protected $table = 'consultants';
    protected $fillable = [
        'fullname',
        'country',
        'state',
        'city',
        'work_authorization',
        'relocate',
        'primary_skill',
        'primary_skill_experience',
        'secondary_skill',
        'secondary_skill_experience',
        'resume',
        'is_active',
        'new_job_report_time',
        'recruiter_id'
    ];


    public function getRecruiter()
    {
        return $this->belongsTo(Recruiter::class,'recruiter_id','id');
    }
}

