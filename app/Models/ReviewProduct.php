<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'review_product';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id_product',
        'id_user',
        'stars',
        'is_hidden_name',
        'stars',
        'description'
    ];
}
