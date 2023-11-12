<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
