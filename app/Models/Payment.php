<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'payment';
    protected $fillable = [
        'id_order',
        'payment_status',
        'url_bukti_transfer',
    ];
}
