<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'feed';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id_user',
        'id_merchant',
        'id_product',
        'like_count',
        'url_image',
        'caption',
        'location',
        'report_count',
        'created_at',
        'updated_at',
    ];

    public function getProduct(){
        return $this->hasOne(Product::class,'id','id_product');
    }
    public function getMerchant(){
        return $this->hasOne(Merchant::class,'id','id_merchant');
    }
}
