<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantCategory extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    protected $table = 'merchant_category';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function merchant(){
        return $this->hasOne(Merchant::class,'id','id_merchant');
    }
    public function product_photo(){
        return $this->hasMany(ProductPhoto::class,'id_product','id');
    }
    public function product_category(){
        return $this->hasOne(ProductCategory::class,'id','id_category');
    }
    public function product(){
        return $this->hasOne(Product::class,'id','id_product');
    }
    // public function getGambar(){
    //     return $this->hasMany(ProductPhoto::class);
    // }
}
