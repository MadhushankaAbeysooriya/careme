<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareTakerProfile extends Model
{
    use HasFactory;

    protected $table = 'care_taker_profiles';
    protected $fillable = [
        'personal_photo',
        'id_front',
        'id_back',
        'bank',
        'user_id',
        'description',
        'agreementstatus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
