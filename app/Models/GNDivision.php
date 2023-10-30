<?php

namespace App\Models;

use App\Models\DSDivision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GNDivision extends Model
{
    use HasFactory;

    protected $table = 'gndivisions';
    protected $fillable = [
        'name',
        'status',
        'dsdivision_id',
    ];

    public function dsdivision()
    {
        return $this->belongsTo(DSDivision::class, 'dsdivision_id', 'id');
    }
}
