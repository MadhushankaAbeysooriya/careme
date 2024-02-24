<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';
    protected $fillable = [
        'content',
        'phone',
        'email',
        'address',
        'bank_name',
        'bank_branch',
        'account_no',
        'account_holder_name',
        'account_type',
    ];
}
