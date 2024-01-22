<?php

namespace App\Models;

use App\Models\User;
use App\Models\Hospital;
use App\Models\PaymentMethod;
use App\Models\PatientRequestStatus;
use App\Models\PatientRequestDeposit;
use App\Models\PatientRequestPayment;
use Illuminate\Database\Eloquent\Model;
use App\Models\PatientRequestPaymentStatusUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientRequest extends Model
{
    use HasFactory;

    protected $table = 'patient_requests';
    protected $fillable = [
        'from',
        'to',
        'status',
        'hospital_id',
        'care_taker_id',
        'patient_id',
        'hrs',
        'total_price',
        'svc_charge',
        'payment_method_id',
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
        return $this->belongsTo(User::class, 'care_taker_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }

    public function patientrequestdeposit()
    {
        return $this->hasOne(PatientRequestDeposit::class);
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
