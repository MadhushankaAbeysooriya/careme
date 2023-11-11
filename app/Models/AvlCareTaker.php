<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvlCareTaker extends Model
{
    use HasFactory;

    protected $table = 'avl_care_takers';
    protected $fillable = [
        'from',
        'to',
        'shift_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
