<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
    {
        $tenancy_id = $team->tenancy_id;

        if(Auth::user()->hasRole('admin', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('team_manager', $tenancy_id))
            return Auth::user()->team_id === $team_id;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        if(Auth::user()->tenancy_id != $team->tenancy_id) return false;

        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $team;

        }
        return false;    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Team $team): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        //
    }
}
