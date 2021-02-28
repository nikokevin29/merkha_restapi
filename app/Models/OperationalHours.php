<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalHours extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'operational_hours';
}
