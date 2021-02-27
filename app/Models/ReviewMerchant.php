<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewMerchant extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'review_merchant';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id_merchant',
        'id_user',
        'id_order',
        'is_hidden_name',
        'stars',
        'description'
    ];
}
