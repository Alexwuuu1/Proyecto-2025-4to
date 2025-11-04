<?php

namespace App\Policies;

use App\Models\Ranking;
use App\Models\User;

class RankingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view rankings
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ranking $ranking): bool
    {
        return true; // Anyone can view individual rankings
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ranking $ranking): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ranking $ranking): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ranking $ranking): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ranking $ranking): bool
    {
        return $user->isAdmin();
    }
}
