<?php

namespace App\Models;

use App\Models\User;
use App\Models\Hospital;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHospital extends Pivot
{
    use HasFactory;
    protected $table = 'user_hospitals';
    protected $fillable = [
        'user_id',
        'hospital_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
