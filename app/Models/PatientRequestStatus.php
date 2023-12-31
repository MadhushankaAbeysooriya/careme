<?php

namespace App\Models;

use App\Models\PatientRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\PatientRequestPaymentStatusUser;
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

    public function patientrequestpaymentstatususer()
    {
        return $this->hasOne(PatientRequestPaymentStatusUser::class,'patient_req_stat_id','id');
    }
}
