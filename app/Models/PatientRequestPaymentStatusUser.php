<?php

namespace App\Models;

use App\Models\User;
use App\Models\PatientRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientRequestPaymentStatusUser extends Model
{
    use HasFactory;

    protected $table = 'patient_request_payment_status_users';
    protected $fillable = [
        'patient_req_stat_id',
        'user_id',
    ];

    public $timestamps = false; // Disable timestamps

    public function patientrequeststatus()
    {
        return $this->belongsTo(PatientRequestStatus::class, 'patient_req_stat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
