<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();

        return view('teams.list-teams', compact(
                'teams',
            ));
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
        $team = Team::create([
            'name' => $request->name,
            'tenancy_id' => Auth::user()->tenancy_id,
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
        //
    }
}
