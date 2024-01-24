<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerRole extends Model
{
    use HasFactory;

    protected $table = 'employer_role';
    protected $fillable = [
        'name',
    ];

}
