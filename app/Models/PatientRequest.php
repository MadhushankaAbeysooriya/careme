<?php

namespace App\Models;

use App\Models\User;
use App\Models\Hospital;
use App\Models\PatientRequestStatus;
use App\Models\PatientRequestPayment;
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

    public function patientrequestpayment()
    {
        return $this->hasOne(PatientRequestPayment::class);
    }

    public function caretaker()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
