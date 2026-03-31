<?php

namespace App\Policies;

use App\Models\HistorialSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HistorialSessionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read historialSession');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HistorialSession $historialSession): bool
    {
        return $user->can('read historialSession');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HistorialSession $historialSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HistorialSession $historialSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HistorialSession $historialSession): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HistorialSession $historialSession): bool
    {
        return false;
    }
}
