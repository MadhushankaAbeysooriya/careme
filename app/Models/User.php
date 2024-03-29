<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rank;
use App\Models\Forces;
use App\Models\Hospital;
use App\Models\Language;
use App\Models\Usertype;
use App\Models\UserRating;
use App\Models\UserHospital;
use App\Models\UserBlackList;
use App\Models\CareTakerProfile;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'fname',
        'lname',
        'phone',
        'user_type',
        'gender',
        'deviceId',
        'dob',
        'login_status',
        'black_list',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'user_hospitals')
            ->using(UserHospital::class); // Using the custom pivot model
    }

    public function caretakerprofile()
    {
        return $this->hasOne(CareTakerProfile::class);
    }

    public function ratings()
    {
        return $this->hasMany(UserRating::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class,'user_languages');
    }

    public function userblacklist()
    {
        return $this->hasMany(UserBlackList::class);
    }
}
