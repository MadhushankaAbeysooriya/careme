<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLanguage extends Pivot
{
    use HasFactory;

    protected $table = 'user_languages';
    protected $fillable = [
        'user_id',
        'language_id',
    ];
}
