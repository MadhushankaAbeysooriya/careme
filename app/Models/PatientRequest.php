<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRequest extends Model
{
    use HasFactory;

    protected $table = 'patient_requests';
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'status',
        'shift_id',
        'hospital_id',
        'patient_id',
    ];
}
