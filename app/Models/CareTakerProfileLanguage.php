<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareTakerProfileLanguage extends Pivot
{
    use HasFactory;

    protected $table = 'care_taker_profile_languages';
    protected $fillable = [
        'care_taker_profile_id',
        'language_id',
    ];
}
