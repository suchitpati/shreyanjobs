<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchJob extends Model
{
    use HasFactory;

    protected $table = "batch_jobs";

    protected $fillable = [
        'batch_job_name',
        'status'
    ];

}
