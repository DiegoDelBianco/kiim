<?php

namespace App\Policies;

use App\Models\CustomerCsvImport;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class CustomerCsvImportPolicy
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
    public function view(User $user, CustomerCsvImport $customerCsvImport): bool
    {
        //if(Auth::user()->tenancy_id != $customerCsvImport->tenancy_id) return false;

        if(Auth::user()->hasRole('Master', $customerCsvImport->tenancy_id)) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente', $customerCsvImport->tenancy_id)) {
            return true;

        } else {
            return false;

        }
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
    public function update(User $user, CustomerCsvImport $customerCsvImport): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerCsvImport $customerCsvImport): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerCsvImport $customerCsvImport): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerCsvImport $customerCsvImport): bool
    {
        //
    }
}
