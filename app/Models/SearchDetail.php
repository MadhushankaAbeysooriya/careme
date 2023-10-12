<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchDetail extends Model
{
    use HasFactory;
    protected $table = 'search_details';
    protected $fillable = [
        'nic',
        'user_id',
        'reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
