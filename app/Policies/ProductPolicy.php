<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class ProductPolicy
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
    public function view(User $user, Product $product): bool
    {
        $tenancy_id = $product->tenancy_id;

        if(Auth::user()->hasRole('admin', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('team_manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('basic', $tenancy_id))
            return true;

        //if(Auth::user()->hasRole('Assistente'))
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
    public function update(User $user, Product $product): bool
    {
        $tenancy_id = $product->tenancy_id;

        if(Auth::user()->hasRole('admin', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('manager', $tenancy_id))
            return true;

        if(Auth::user()->hasRole('team_manager', $tenancy_id))
            return false;

        //if(Auth::user()->hasRole('Assistente'))
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        //
    }
}
