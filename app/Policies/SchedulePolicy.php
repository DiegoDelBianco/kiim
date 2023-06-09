<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchedulePolicy
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
    public function view(User $user, Schedule $schedule): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, CustomerService $customer_service): bool
    {
        if(Auth::user()->tenancy_id != $customer_service->tenancy_id) return false;

        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $customer_service->customer->team_id;

        } else {
            return Auth::user()->id === $customer_service->customer->user_id;

        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        if(Auth::user()->tenancy_id != $schedule->tenancy_id) return false;

        if(Auth::user()->hasRole('Master')) {
            return true;

        } elseif(Auth::user()->hasRole('Gerente')) {
            return Auth::user()->team_id === $schedule->user->team_id;

        } else {
            return Auth::user()->id === $schedule->user->user_id;

        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Schedule $schedule): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Schedule $schedule): bool
    {
        //
    }
}
