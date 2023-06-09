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

    public function view(User $user, $userEditar)
    {
        if(Auth::user()->tenancy_id != $user->tenancy_id) return false;
        
        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $userEditar->team_id;

        } elseif(Auth::user()->hasRole('Assistente')) {
            return false;

        }
    }

    public function update(User $user, $userEditar)
    {
        if(Auth::user()->tenancy_id != $user->tenancy_id) return false;

        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $userEditar->team_id;

        } elseif(Auth::user()->hasRole('Assistente')) {
            return false;

        }
    }
}
