<?php

namespace App\Models;

use App\Models\User;
use App\Models\AdvertisementCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisement extends Model
{
    use HasFactory;

    protected $table = 'advertisements';
    protected $fillable = [
        'name',
        'filepath',
        'status',
        'user_id',
        'advertisement_category_id',
        'amount',
        'total',
        'url',
        'from',
        'to',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advertisementcategory()
    {
        return $this->belongsTo(AdvertisementCategory::class, 'advertisement_category_id', 'id');
    }
}
