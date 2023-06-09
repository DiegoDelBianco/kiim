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

        Gate::define('manage-users', function($user){
            return $user->hasAnyRoles(['Master', 'Gerente']);
        });

        Gate::define('edit-users', function($user){
            return $user->hasAnyRoles(['admin', 'author']);
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
    }
}
