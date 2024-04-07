<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateLimit extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function details()
    {
        return $this->hasMany('\App\Models\RateLimitDetail');
    }
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    public function customer()
    {
        return $this->belongsTo('\App\Models\Customer');
    }
}
