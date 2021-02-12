<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Order extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    protected $table = 'order';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id_merchant',
        'id_buyer',
        'id_destination',
        'id_voucher',
        'id_campaign',
        'received_date',
        'order_status',
        'shipping_price',
        'discount_price',
        'total_price',
    ];

    public function getVoucher(){
        return $this->hasOne(Voucher::class,'id','id_voucher');
    }
    // public function getUser(){
    //     return $this->hasOne(User::class,'id','id_buyer');
    // }

    public function getAddress(){
        return $this->belongsTo(Address::class,'id_buyer','id_user');
    }
    public function getDetails(){
        return $this->hasMany(OrderDetail::class,'id_order','id');
    }
    public function getMerchant(){
        return $this->belongsTo(Merchant::class,'id_merchant','id');
    }
    public static function orderNumber(){
        $date = Carbon::now();
        $getYear = $date->year;
        $getYear = substr($getYear,-2);
        $getMonth = $date->format('m');
        $getDay = $date->format('d');
        return "ORD".$getDay.$getMonth.$getYear;
    }


}
