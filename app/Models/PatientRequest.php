<?php

namespace App\Models;

use App\Models\PatientRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'rate',
        'total_price',
    ];

    public function patientrequeststatus()
    {
        return $this->hasMany(PatientRequestStatus::class);
    }
}
