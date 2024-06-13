<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'price',
        'img_url',
        'description'
    ];

    //リレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
