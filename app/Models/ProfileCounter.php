<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCounter extends Model
{
    use HasFactory;
    protected $table = 'profile_counter';

    protected $fillable = ['profile_type','profle_count'];
}
