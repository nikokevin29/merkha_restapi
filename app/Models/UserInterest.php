<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    use HasFactory;
    protected $table = 'user_interest';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_category',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function getCategory(){
        return $this->hasMany(ProductCategory::class,'id','id_category');
    }
}
