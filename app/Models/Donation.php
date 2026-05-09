<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donation_request_id',
        'user_id',
        'quantity_donated',
        'status',
    ];

    public function donationRequest()
    {
        return $this->belongsTo(DonationRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
