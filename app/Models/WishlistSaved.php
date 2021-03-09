<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistSaved extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wishlist_saved';
    protected $fillable = [
        'id_user',
        'id_product',
    ];
}
