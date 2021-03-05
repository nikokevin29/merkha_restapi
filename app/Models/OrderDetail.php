<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'order_detail';
    protected $fillable = [
        'id_order',
        'id_product',
        'amount',
        'subtotal',
        'product_price'
    ];
}
