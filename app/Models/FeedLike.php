<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedLike extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'feed_like';
    protected $fillable = [
        'id_user',
        'id_feed',
    ];
}
