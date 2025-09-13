<?php

namespace App\Policies;

use App\Models\CivilAct;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CivilActPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view civil acts
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CivilAct $civilAct): bool
    {
        // Citizens can only view their own civil acts
        if ($user->isCitizen()) {
            return $user->id === $civilAct->user_id;
        }

        // Agents and admins can view all civil acts
        return $user->isAgent() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isCitizen();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CivilAct $civilAct): bool
    {
        // Citizens can only update their own draft civil acts
        if ($user->isCitizen()) {
            return $user->id === $civilAct->user_id && $civilAct->status === 'draft';
        }

        // Agents and admins can update civil acts they have access to
        return $user->isAgent() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CivilAct $civilAct): bool
    {
        // Citizens can only delete their own draft civil acts
        if ($user->isCitizen()) {
            return $user->id === $civilAct->user_id && $civilAct->status === 'draft';
        }

        // Only admins can delete civil acts
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can validate the model.
     */
    public function validate(User $user, CivilAct $civilAct): bool
    {
        // Only agents and admins can validate civil acts
        return $user->isAgent() || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CivilAct $civilAct): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CivilAct $civilAct): bool
    {
        return $user->isAdmin();
    }
}