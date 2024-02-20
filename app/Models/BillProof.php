<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillProof extends Model
{
    use HasFactory;

    protected $table = 'bill_proofs';
    protected $fillable = [
        'name',
        'status',
    ];
}
