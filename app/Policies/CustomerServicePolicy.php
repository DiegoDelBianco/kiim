<?php

namespace App\Policies;

use App\Models\CustomerService;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class CustomerServicePolicy
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
    public function view(User $user, CustomerService $customerService): bool
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
    public function update(User $user, CustomerService $customerService): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerService $customerService): bool
    {
        if(Auth::user()->tenancy_id != $customerService->tenancy_id
            AND $customerService->user_id != Auth::user()->id ) return false;

        return true;
/*
        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $customerService->customer->team_id;

        } else {
            return Auth::user()->id === $customerService->customer->user_id;

        }*/
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerService $customerService): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerService $customerService): bool
    {
        //
    }
}
