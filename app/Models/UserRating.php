<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRating extends Model
{
    use HasFactory;

    protected $table = 'user_ratings';
    protected $fillable = [
        'user_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
