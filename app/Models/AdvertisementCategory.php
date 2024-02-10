<?php

namespace App\Models;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertisementCategory extends Model
{
    use HasFactory;

    protected $table = 'advertisement_categories';
    protected $fillable = [
        'name',
        'amount',
        'status',
    ];

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
