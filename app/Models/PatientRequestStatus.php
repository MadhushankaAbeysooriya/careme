<?php

namespace App\Models;

use App\Models\PatientRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientRequestStatus extends Model
{
    use HasFactory;

    protected $table = 'patient_request_statuses';
    protected $fillable = [
        'patient_request_id',
        'status',
        'date',
    ];

    public function patientrequest()
    {
        return $this->belongsTo(PatientRequest::class, 'patient_request_id', 'id');
    }
}
