<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'post_number',
        'address',
        'building_name',
        'icon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
