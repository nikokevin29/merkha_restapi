<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ApiCode;
use Hash;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    public $timestamps = true;
    protected $table = 'user';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'gender',
        'email',
        'password',
        'phone_number',
        'url_photo',
        'bio',
        'followers_count',
        'following_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'created_at'        => 'datetime:Y-m-d H:i:s',
        'updated_at'        => 'datetime:Y-m-d H:i:s',
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getAddress(){
        return $this->hasMany(Address::class,'id_user');
    }
}
