<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginDetail extends Model
{
    use HasFactory;
    protected $table = 'login_details';
    protected $fillable = [        
        'user_id',
        'login_ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
