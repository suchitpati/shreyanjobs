<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchJobLog extends Model
{
    use HasFactory;
    protected $table = "batch_job_log";

    protected $fillable = [
        'batch_job_name',
        'status',
        'process_count',
        'email_sent_count',
        'job_start_time',
        'error_message',
        'job_end_time'
    ];

}
