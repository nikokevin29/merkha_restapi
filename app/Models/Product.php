<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    protected $table = 'product';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getCategory(){
        return $this->hasOne(ProductCategory::class,'id','id_category');
    }
    public function getMerchant(){
        return $this->hasOne(Merchant::class,'id','id_merchant');
    }
    public function getPhoto(){
        return $this->hasMany(ProductPhoto::class,'id_product','id');
    }
}