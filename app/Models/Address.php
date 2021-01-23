<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamp = true;
    protected $table = 'address';

    protected $fillable = [
        'id_user',
        'address_save_name',
        'address',
        'postal_code',
        'city',
        'province',
        'id_city',
        'id_province',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
