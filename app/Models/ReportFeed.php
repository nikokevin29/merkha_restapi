<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFeed extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'report_feed';
    protected $fillable = [
        'id_feed',
        'id_user',
    ];
}
