<?php

namespace App\Models;

use App\Models\PatientRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complain extends Model
{
    use HasFactory;

    protected $table = 'complains';
    protected $fillable = [
        'user_id',
        'status',
        'topic',
        'complain',
        'patient_request_id',
    ];

    public function patientrequest()
    {
        return $this->belongsTo(PatientRequest::class, 'patient_request_id', 'id');
    }
}
