<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $table = 'district';
    protected $fillable = [
        'name',
        'status',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
