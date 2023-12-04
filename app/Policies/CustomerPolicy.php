<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class CustomerPolicy
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
    public function view(User $user, Customer $customer): bool
    {
        $tenancy_id = $customer->tenancy_id;

        if(Auth::user()->hasAnyRoles(['admin', 'manager'], $tenancy_id))
            return true;

        if(Auth::user()->hasAnyRoles(['team_manager'], $tenancy_id)){
            if(Auth::user()->teamId($tenancy_id) === $customer->team_id)
                return true;
        }

        if(Auth::user()->hasAnyRoles(['basic'], $tenancy_id)
            AND Auth::user()->id === $customer->user_id)
                return true;

        return false;
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
    public function update(User $user, Customer $customer): bool
    {
        if(Auth::user()->tenancy_id != $customer->tenancy_id
            AND $customer->user_id != Auth::user()->id ) return false;

        return true;

        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $customer->team_id;

        } else {
            return Auth::user()->id === $customer->user_id;

        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        $tenancy_id = $customer->tenancy_id;

        if(Auth::user()->hasAnyRoles(['admin', 'manager'], $tenancy_id))
            return true;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        //
    }
}
