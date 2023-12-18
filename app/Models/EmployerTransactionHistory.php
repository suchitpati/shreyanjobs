<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerTransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'employer_transaction_history';
    protected $fillable = [
        'employer_id',
        'begin_balance',
        'transaction_amount',
        'end_balance',
        'transaction_date',
        'action_name',
        'job_seeker_id'
    ];
}
