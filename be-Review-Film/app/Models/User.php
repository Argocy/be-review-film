<?php

namespace App\Models;

use Carbon\Carbon;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;
    public $timestamps = true;


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }



    public static function boot() {
        parent::boot();

        static::created(function($model){
            $model->generate_code();
        });
    }


    public function generate_code() {
        do {
            $randomNumber = mt_rand(100000, 999999);
            $check = OtpCode::where('otp', $randomNumber)->first();
        } while ($check);

        $now = Carbon::now();
        $otpcode = OtpCode::updateOrCreate(
            ['users_id' => $this->id], [
                'otp' => $randomNumber,
                'valid_until' => $now->addMinutes(5),
               
            ]
            );
    }

    public function dataotp() {
        return $this->hasOne(OtpCode::class, 'users_id');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role_id'
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

}
