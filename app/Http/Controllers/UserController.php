<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::denies('manage-users')){
            return redirect(route('dashboard'));
        }

        $users = User::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $teams = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();

        return view('users.list-users', ['users' => $users, 'teams' => $teams]);
    }


    public function listByTeam(Request $request)
    {
        $where[] = ['tenancy_id', '=', Auth::user()->tenancy_id];
        if($request->team_id)  $where[] = ['team_id', "=", $request->team_id];
        $users = User::where($where)->get();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(User::where('tenancy_id', Auth::user()->tenancy_id)->count() >= Auth::user()->tenancy->max_users)
            return redirect()->back()->with('error', 'Sua conta bateu o limite de usuário, faça um update para adicionar mais.'); 

        if(Gate::denies('manage-users'))
            return redirect(route('home'));


        $validaemail = User::where([['email', '=', $request->email]])->get();
    
        if(count($validaemail) > 0)  
            return redirect()->back()->with('error', 'E-mail já está em uso por outro usuário no sistema');

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'team_id'       => $request->team_id,
                'password'      => Hash::make($request->password),
                'tenancy_id'    => Auth::user()->tenancy_id
            ]);


        if($user) {
            return redirect()->route('users')->with('success','Usuário criado!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao criar o usuário.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('view', $user);

        if(Gate::denies('manage-users'))
            return redirect(route('home'));

        $roles = Role::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $teams = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();

        return view('users.edit-user', [
            'user' => $user,
            'roles' => $roles,
            'teams' => $teams
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validaemail = User::where([['email', '=', $request->email],['id', '<>', $user->id]])->get() ;
    
        if(count($validaemail) > 0)  
            return redirect()->back()->with('error', 'E-mail já está em uso por outro usuário no sistema');
        
        $roles_tenancy = [];
        if($request->roles){
        foreach($request->roles as $role)
            $roles_tenancy[$role] = ['tenancy_id' => Auth::user()->tenancy_id];
        }
        $user->roles()->sync($roles_tenancy);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->team_id = $request->equipeEditUser;

        // $user->websites()->sync($request->websites);

        if($user->save()) {
            return redirect()->route('users')->with('success','Dados do usuário atualizados com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao editar usuário.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user->update(['password'=> Hash::make($request->password)]);

        return redirect()->route('users')->with('success', 'Senha alterada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
