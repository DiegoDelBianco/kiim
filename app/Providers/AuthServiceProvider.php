<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\Policies\CustomerPolicy;
use App\Policies\UserPolicy;
use App\Models\Customer;
use App\Models\User;
use App\Policies\WebsitePolicy;
use App\Models\Website;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        User::class => UserPolicy::class,
        Website::class => WebsitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-users', function($user, $tenancy_id = Null){
            if($tenancy_id == NULL)
                $tenancy_id = Auth::user()->tenancy_id;

            return $user->hasAnyRoles(['admin', 'manager', 'team_manager'], $tenancy_id);
        });

        Gate::define('manage-teams', function($user, $tenancy_id = Null){
            if($tenancy_id == NULL)
                $tenancy_id = Auth::user()->tenancy_id;

            return $user->hasAnyRoles(['admin', 'manager', 'team_manager'], $tenancy_id);
        });

        Gate::define('manage-products', function($user, $tenancy_id = Null){
            if($tenancy_id == NULL)
                $tenancy_id = Auth::user()->tenancy_id;

            return $user->hasAnyRoles(['admin', 'manager', 'team_manager'], $tenancy_id);
        });

        Gate::define('manage-any-users', function($user, $tenancy_id){
            return $user->hasAnyRoles(['admin', 'manager', 'team_manager'], $tenancy_id);
        });

        Gate::define('edit-users', function($user){
            return $user->hasAnyRoles(['admin', 'manager', 'team_manager']);
        });

        Gate::define('delete-users', function($user){
            return $user->hasRole('admin');
        });

        Gate::define('Master', function($user){
            return $user->hasRole('Master');
        });

        Gate::define('Assistente', function($user){
            return $user->hasRole('Assistente');
        });

        Gate::define('eqpVendas', function($user){
            return Auth::user()->sector_id == 3;
        });

        Gate::define('setorTi', function($user){
            return (Auth::user()->sector_id == 2) || (Auth::user()->hasRole('Master'));
        });

        Gate::define('eqpAdmin', function($user){
            return Auth::user()->sector_id == 1;
        });

        Gate::define('store-customer', function($user){
            return true;
        });
        Gate::define('customer-redirect', function($user, $customer){


            $tenancy_id = $customer->tenancy_id;

            if(Auth::user()->hasAnyRoles(['admin', 'manager'], $tenancy_id))
                return true;

            if(Auth::user()->hasAnyRoles(['team_manager'], $tenancy_id)){
                if(Auth::user()->teamId($tenancy_id) === $customer->team_id)
                    return true;
            }


            return false;
        });



        // Define quais menus estão disponiveis
        Gate::define('menu-h-sales', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-customer-list', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-customer-service', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-customer-service-remarketing', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-websites-list', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return false;

            } else {
                return false;

            }
        });
        Gate::define('menu-shedules', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-sales', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return false;

            } else {
                return false;

            }
        });
        Gate::define('menu-h-business', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return false;

            }
        });
        Gate::define('menu-teams-list', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return false;

            }
        });
        Gate::define('menu-users-list', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return false;

            }
        });
        Gate::define('menu-products', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return false;

            }
        });
        Gate::define('menu-config', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return false;

            } else {
                return false;

            }
        });
        Gate::define('menu-h-administrative', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return false;

            }
        });
        Gate::define('menu-metrics', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-h-account', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });
        Gate::define('menu-account', function($user){

            if(Auth::user()->hasRole('Master')) {
                return true;

            } elseif(Auth::user()->hasRole('Gerente')) {
                return true;

            } else {
                return true;

            }
        });


    }
}
