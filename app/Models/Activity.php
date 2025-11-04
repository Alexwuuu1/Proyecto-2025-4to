<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'start_date',
        'end_date',
        'location',
        'max_participants',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the current number of participants
     */
    public function getCurrentParticipantsAttribute()
    {
        return $this->users()->count();
    }

    /**
     * Check if activity is full
     */
    public function isFull()
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->current_participants >= $this->max_participants;
    }

    /**
     * Check if activity is upcoming
     */
    public function isUpcoming()
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    /**
     * Check if activity is ongoing
     */
    public function isOngoing()
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }
        return now()->between($this->start_date, $this->end_date);
    }

    /**
     * Check if activity is completed
     */
    public function isCompleted()
    {
        return $this->end_date && $this->end_date->isPast();
    }
}
