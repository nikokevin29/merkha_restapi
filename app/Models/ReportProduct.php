<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'report_product';
    protected $fillable = [
        'id_product',
        'id_user',
    ];
}
