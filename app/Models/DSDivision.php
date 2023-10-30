<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSDivision extends Model
{
    use HasFactory;

    protected $table = 'dsdivisions';
    protected $fillable = [
        'id',
        'name',
        'status',
        'district_id',
        'created_at',
        'updated_at'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
