<?php

namespace App\Models;

use App\Models\CareTakerProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'status',
    ];

    public function careTakerProfiles()
    {
        return $this->belongsToMany(CareTakerProfile::class);
    }
}
