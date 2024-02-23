<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBlackList extends Model
{
    use HasFactory;
    protected $table = 'user_black_lists';
    protected $fillable = [
        'user_id',
        'created_by',
        'black_listed_date',
        'activating_date',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
