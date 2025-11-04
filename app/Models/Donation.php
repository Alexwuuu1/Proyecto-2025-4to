<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'amount',
        'type',
        'status',
        'donation_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donation_date' => 'date',
    ];

    /**
     * Get the user that owns the donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if donation is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if donation is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if donation is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
