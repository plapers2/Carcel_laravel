<?php

namespace App\Policies;

use App\Filament\Pages\Reportes;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("read reportes");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reportes $report): bool
    {
        return $user->can("read reportes");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("download reportes");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reportes $report): bool
    {
        return $user->can("descargar reportes");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reportes $report): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Report $report): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return false;
    }
}
