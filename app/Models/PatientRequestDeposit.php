<?php

namespace App\Models;

use App\Models\User;
use App\Models\PatientRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientRequestDeposit extends Model
{
    use HasFactory;
    protected $table = 'patient_request_deposits';
    protected $fillable = [
        'patient_request_id',
        'user_id',
        'filepath',
    ];

    public function patientrequest()
    {
        return $this->belongsTo(PatientRequest::class, 'patient_request_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
