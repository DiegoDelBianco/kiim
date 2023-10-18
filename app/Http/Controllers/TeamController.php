<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\Tenancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gate;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenancies = [];
        $teams_by_tenancy = [];

        foreach(Auth::user()->roles as $tenancy){
            if(Auth::user()->can('manage-teams', $tenancy->tenancy_id)){
                $current_tenancy = Tenancy::find($tenancy->tenancy_id);
                $tenancies[$tenancy->tenancy_id] = $current_tenancy;
                $teams_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->teams;
            }
        }

        return view('teams.list-teams', ['teams_by_tenancy' => $teams_by_tenancy, 'tenancies' => $tenancies]);

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

        if(Gate::denies('manage-teams', $tenancy->id))
            return redirect()->back()->with('error', 'Você não tem permissão para criar equipes nesta empresa');


        $team = Team::create([
            'name' => $request->name,
            'tenancy_id' => $tenancy_id,
        ]);

        if($team) {
            return redirect()->back()->with('success','Equipe adicionada!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao adicionar a equipe.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {

        $this->authorize('update', $team);

        $team->name = $request->name;
        $team->save();

        return redirect()->back()->with('success','Alteração salva!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {

        $this->authorize('update', $team);

        $team->delete();

        return redirect()->back()->with('success','Equipe removida!');
    }
}
