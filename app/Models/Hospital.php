<?php

namespace App\Models;

use App\Models\User;
use App\Models\District;
use App\Models\UserHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;
    protected $table = 'hospitals';
    protected $fillable = [
        'name',
        'status',
        'district_id',
        'type',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_hospitals', 'hospital_id', 'user_id');
    }
}
