<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRequestDescription extends Model
{
    use HasFactory;

    protected $table = 'patient_request_descriptions';
    protected $fillable = [
        'name',
        'status',
    ];
}
