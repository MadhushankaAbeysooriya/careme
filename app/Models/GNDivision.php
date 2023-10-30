<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GNDivision extends Model
{
    use HasFactory;

    protected $table = 'gndivisions';
    protected $fillable = [
        'name',
        'status',
        'district_id',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
