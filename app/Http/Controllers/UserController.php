<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use App\Models\Tenancy;
use App\Models\RoleUser;
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

        $tenancies = [];
        $users_by_tenancy = [];
        $teams_by_tenancy = [];

        foreach(Auth::user()->roles as $tenancy){
            if(Auth::user()->can('manage-users', $tenancy->tenancy_id)){
                $current_tenancy = Tenancy::find($tenancy->tenancy_id);
                $tenancies[$tenancy->tenancy_id] = $current_tenancy;
                $users_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->users;
                $teams_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->teams;
            }
        }

        return view('users.list-users', ['users_by_tenancy' => $users_by_tenancy, 'teams_by_tenancy' => $teams_by_tenancy, 'tenancies' => $tenancies]);
    }


    public function listByTeam(Request $request)
    {
        if(!$request->team_id) return [];

        $team = Team::find($request->team_id);

        if(!$team) return [];

        $this->authorize('listByTeam', $team);

        return $team->users;
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
        $tenancy_id = $request->tenancy_id;
        $tenancy = Tenancy::find($tenancy_id);

        if(!$tenancy)
            return redirect()->back()->with('error', 'Empresa não encontrada');

        if(Gate::denies('manage-users', $tenancy->id))
            return redirect()->back()->with('error', 'Você não tem permissão para criar usuários nesta empresa');

        if(count($tenancy->users) >= $tenancy->max_users)
            return redirect()->back()->with('error', 'Sua conta bateu o limite de usuário, faça um update para adicionar mais.');

        $validaemail = User::where([['email', '=', $request->email]])->get();

        if(count($validaemail) > 0)
            return redirect()->back()->with('error', 'E-mail já está em uso por outro usuário no sistema');

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'creci' => 'required|string|max:255',
        ]);

        $user = Tenancy::newTenancyWithUser(
            $request->name,
            $request->name,
            $request->email,
            $request->password,
            $request->creci,
        );

        // assign roles to user
        RoleUser::create([
            'user_id' => $user->id,
            'name' => 'basic',
            'tenancy_id' => $tenancy_id,
        ]);

        if($user) {
            return redirect()->route('users')->with('success','Usuário criado!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao criar o usuário.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function link(Request $request)
    {

        $tenancy_id = $request->tenancy_id;
        $tenancy = Tenancy::find($tenancy_id);

        if(!$tenancy)
            return redirect()->back()->with('error', 'Empresa não encontrada');

        if(Gate::denies('manage-users', $tenancy->id))
            return redirect()->back()->with('error', 'Você não tem permissão para criar usuários nesta empresa');

        if(count($tenancy->users) >= $tenancy->max_users)
            return redirect()->back()->with('error', 'Sua conta bateu o limite de usuário, faça um update para adicionar mais.');

        $user = User::where([['email', '=', $request->email]])->first();
        if(!$user)
            return redirect()->back()->with('error', 'Usuário não existe no sistema');

        $link = RoleUser::where([['user_id', '=', $user->id], ['tenancy_id', '=', $tenancy_id]])->first();
        if($link)
            return redirect()->back()->with('error', 'Usuário já está vinculado a esta empresa');

        // assign roles to user
        RoleUser::create([
            'user_id' => $user->id,
            'name' => 'basic',
            'tenancy_id' => $tenancy_id,
        ]);

        if($user) {
            return redirect()->route('users')->with('success','Usuário vinculado!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao vincular o usuário.');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function unlink(Tenancy $tenancy, User $user)
    {
        $this->authorize('view', [$user, $tenancy->id]);

        if($tenancy->user_id == $user->id)
            return redirect()->back()->with('error', 'Você não pode desvincular o usuário principal da empresa');

        if(!$user)
            return redirect()->back()->with('error', 'Usuário não encontrado');

        if(!$tenancy->user_id)
            return redirect()->back()->with('error', 'Empresa não encontrada');

        $link = RoleUser::where([['user_id', '=', $user->id], ['tenancy_id', '=', $tenancy->id]])->first();

        if(!$link)
            return redirect()->back()->with('error', 'Usuário não está vinculado a esta empresa');

        $link->delete();

        return redirect()->route('users')->with('success','Usuário desvinculado!');
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
    public function edit(Tenancy $tenancy, User $user)
    {
        $this->authorize('view', [$user, $tenancy->id]);

        if(Gate::denies('manage-users', $tenancy->id))
            return redirect(route('home'));

        $roles = RoleUser::get_roles_list();
        $teams = $tenancy->teams;

        $rel = $user->roles()->where('tenancy_id', $tenancy->id)->first();

        return view('users.edit-user', [
            'user' => $user,
            'tenancy' => $tenancy,
            'roles' => $roles,
            'teams' => $teams,
            'rel'   => $rel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenancy $tenancy, User $user)
    {
        $this->authorize('update', [$user, $tenancy->id]);

        if($tenancy->user_id == $user->id)
            return redirect()->back()->with('error', 'Você não pode editar o usuário principal da empresa');

        //$validaemail = User::where([['email', '=', $request->email],['id', '<>', $user->id]])->get() ;

        //if(count($validaemail) > 0)
        //    return redirect()->back()->with('error', 'E-mail já está em uso por outro usuário no sistema');

        if(!isset($request->roles[0]))
            return redirect()->back()->with('error', 'Privilégio não selecionado');

        if(!RoleUser::roleIsset($request->roles[0]))
            return redirect()->back()->with('error', 'Privilégio selecionado inválido');

        $team = Team::find($request->equipeEditUser);

        if($team and !$request->equipeEditUser)
            return redirect()->back()->with('error', 'Equipe inválida');

        if($team ? $team->tenancy_id != $tenancy->id : false)
            return redirect()->back()->with('error', 'Equipe inválida');

        $role = RoleUser::where('user_id', $user->id)->where('tenancy_id', $tenancy->id)->first();
        if(!$role)
            return redirect()->back()->with('error', 'Usuário não encontrado');

        $role->name = $request->roles[0];
        $role->save();

        //$roles_tenancy = [];
        //if($request->roles){
        //foreach($request->roles as $role)
            //$roles_tenancy[$role] = ['tenancy_id' => Auth::user()->tenancy_id];
        //}
        //$user->roles()->sync($roles_tenancy);




        //$user->name = $request->name;
        //$user->email = $request->email;

        //$user->team_id = $request->equipeEditUser;
        //limit_cs_by_day
        $user->update_limit_cs_by_day($tenancy->id, $request->limitCsByDayEditUser);
        $user->update_team($tenancy->id, $request->equipeEditUser);

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
