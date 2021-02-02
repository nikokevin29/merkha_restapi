<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'comment';
    protected $fillable = [
        'id_user',
        'id_merchant',
        'id_feed',
        'comment',
        'mention',  
        'created_at',
        'updated_at',
    ];

    public function getMerchant(){
        return $this->hasOne(Merchant::class,'id','id_merchant');
    }
    public function getUser(){
        return $this->hasOne(User::class,'id','id_user');
    }
}
