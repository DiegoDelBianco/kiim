<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenancy;
use App\Models\Role;
use App\Models\RoleUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // create a new tenancy
        $tenancy = Tenancy::create([
            'name' => $request->business_name,
        ]);

        // create roles
        $role_master = Role::create([
            'name' => 'Master',
            'description' => 'Administrador',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_gerente = Role::create([
            'name' => 'Gerente',
            'description' => 'Gerente de Equipe',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_basico = Role::create([
            'name' => 'Básico',
            'description' => 'Acesso básico para atendimento',
            'tenancy_id' => $tenancy->id,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenancy_id' => $tenancy->id,
        ]);

        // assign roles to user
        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $role_master->id,
            'tenancy_id' => $tenancy->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
