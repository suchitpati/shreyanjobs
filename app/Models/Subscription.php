<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = "subscription";

    protected $fillable = ['skill','seeker_id'];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
}
