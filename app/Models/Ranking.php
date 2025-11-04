<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ranking extends Model
{
    protected $fillable = [
        'user_id',
        'total_points',
        'activities_completed',
        'hours_volunteered',
        'donations_made',
        'certificates_earned',
        'rank',
        'rank_position',
    ];

    protected $casts = [
        'total_points' => 'integer',
        'activities_completed' => 'integer',
        'hours_volunteered' => 'integer',
        'donations_made' => 'integer',
        'certificates_earned' => 'integer',
        'rank_position' => 'integer',
    ];

    /**
     * Get the user that owns the ranking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate rank based on total points.
     */
    public function calculateRank(): string
    {
        $points = $this->total_points;

        if ($points >= 5000) {
            return 'Diamante';
        } elseif ($points >= 2500) {
            return 'Platino';
        } elseif ($points >= 1000) {
            return 'Oro';
        } elseif ($points >= 500) {
            return 'Plata';
        } else {
            return 'Bronce';
        }
    }

    /**
     * Update ranking statistics.
     */
    public function updateStats(): void
    {
        $user = $this->user;

        $this->activities_completed = $user->activities()->count();
        $this->hours_volunteered = 0; // For now, since activities don't have hours field
        $this->donations_made = $user->donations()->count();
        $this->certificates_earned = $user->certificates()->count();

        // Calculate points: 10 points per activity, 5 points per hour, 20 points per donation, 50 points per certificate
        $this->total_points = ($this->activities_completed * 10) +
                             ($this->hours_volunteered * 5) +
                             ($this->donations_made * 20) +
                             ($this->certificates_earned * 50);

        $this->rank = $this->calculateRank();
        $this->save();
    }

    /**
     * Get top rankings.
     */
    public static function getTopRankings(int $limit = 10)
    {
        return self::with('user')
            ->orderBy('total_points', 'desc')
            ->orderBy('hours_volunteered', 'desc')
            ->take($limit)
            ->get()
            ->each(function ($ranking, $index) {
                $ranking->rank_position = $index + 1;
                $ranking->save();
            });
    }

    /**
     * Update all rankings for all users.
     */
    public static function updateAllRankings(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $ranking = self::firstOrCreate(['user_id' => $user->id]);
            $ranking->updateStats();
        }

        // Update positions
        self::getTopRankings(50); // Update top 50 positions
    }
}
