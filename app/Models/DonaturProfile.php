<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonaturProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
