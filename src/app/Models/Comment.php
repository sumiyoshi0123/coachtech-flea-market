<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'user_id',
        'comment',
    ];

    //リレーション
    public function items()
    {
        return $this->belongsTo(item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userData()
    {
        return $this->belongsTo(UserData::class, 'user_id', 'user_id');
    }
}
