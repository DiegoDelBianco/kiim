<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, $userEditar, $tenancy_id)
    {
        if(Auth::user()->hasRole('admin', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('team_manager', $tenancy_id))
            return Auth::user()->team_id === $userEditar->team_id;

        //if(Auth::user()->hasRole('Assistente'))
        return false;
    }

    public function update(User $user, $userEditar, $tenancy_id)
    {
        if(Auth::user()->hasRole('admin', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('team_manager', $tenancy_id))
            return Auth::user()->team_id === $userEditar->team_id;

        //if(Auth::user()->hasRole('Assistente'))
        return false;
    }
}
