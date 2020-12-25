<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'merchant';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getMerchantCategory(){
        return $this->hasOne(MerchantCategory::class,'id','id_merchant_category');
    }
    public function getBusinessType(){
        return $this->hasOne(BusinessType::class,'id','id_business_type');
    }
}
