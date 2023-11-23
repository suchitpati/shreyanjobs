<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'state',
        'city',
        'remote',
        'skill',
        'year_of_experience',
        'employment_type',
        'short_description',
        'detailed_description',
        'job_title',
        'search_count',
        'email',
        'contact_number',
        'additional_detail',
        'technical_skill'
    ];
}
