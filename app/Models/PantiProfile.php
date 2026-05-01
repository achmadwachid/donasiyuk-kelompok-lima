<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'photo_path',
        'head_name',
        'nib_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
