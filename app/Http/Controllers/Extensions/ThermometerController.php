<?php

namespace App\Http\Controllers\Extensions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Extensions\Thermometer;
use App\Models\ExtensionConfig;

class ThermometerController extends Controller
{
    public function index()
    {
        $goals = Thermometer::where('tenancy_id', Auth::user()->tenancy_id)->orderBy('goal', 'asc')->get();
        $images = Thermometer::getImages();
        return view('extensions/thermometer/index', compact('goals', 'images'));
    }
    //upGoal
    //delGoal

    public function newGoal(Request $request)
    {
        $request->validate([
            //'tenancy_id' => 'required',
            'title' => 'required',
            //'award_value' => 'required',
            //'set_limit_lead' => 'required',
            'goal' => 'required',
            //'goal_type' => 'required',
        ]);

        $goal = Thermometer::create([
            'tenancy_id' => Auth::user()->tenancy_id,//$request->tenancy_id,
            'title' => $request->title,
            'award_value' =>  str_replace(',', '.', str_replace('.', '', $request->award_value)) ,
            'set_limit_lead' => $request->set_limit_lead,
            'goal' => $request->goal,
            'goal_type' => 'sell',
            'trophy_svg' => $request->trophy_svg,
        ]);
        $goal->save();

        return redirect()->route('extensions.thermometer')->with('success', 'Meta criada com sucesso!');
    }

    public function upGoal(Request $request, Thermometer $goal)
    {
        $request->validate([
            //'tenancy_id' => 'required',
            'title' => 'required',
            //'award_value' => 'required',
            //'set_limit_lead' => 'required',
            'goal' => 'required',
            //'goal_type' => 'required',
        ]);

        $goal->title = $request->title;
        $goal->award_value = str_replace(',', '.', str_replace('.', '', $request->award_value));
        $goal->set_limit_lead = $request->set_limit_lead;
        $goal->goal = $request->goal;
        $goal->goal_type = 'sell';
        $goal->trophy_svg = $request->trophy_svg;
        $goal->save();

        return redirect()->route('extensions.thermometer')->with('success', 'Meta atualizada com sucesso!');
    }

    public function delGoal(Thermometer $goal)
    {
        $goal->delete();

        return redirect()->route('extensions.thermometer')->with('success', 'Meta deletada com sucesso!');
    }

    public function config(Request $request)
    {

        if($request->has('rules')){
            ExtensionConfig::setValue('thermometer', 'rules', $request->rules);
        }

        return redirect()->route('extensions.thermometer')->with('success', 'Termômetro configurado com sucesso!');
    }

}
