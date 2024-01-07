<?php

namespace App\Models;

use App\Models\User;
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

    public function users()
    {
        return $this->belongsToMany(User::class,'user_languages');
    }
}
