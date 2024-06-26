<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Team;
use App\Models\Website;
use App\Models\User;
use App\Models\Tenancy;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $tenancies = [];
        $users_by_tenancy = [];
        $teams_by_tenancy = [];

        foreach(Auth::user()->roles as $tenancy){
            $current_tenancy = Tenancy::find($tenancy->tenancy_id);
            $tenancies[$tenancy->tenancy_id] = $current_tenancy;
            $teams_by_tenancy[$tenancy->tenancy_id] = [];
            $users_by_tenancy[$tenancy->tenancy_id] = [];
            $stages_by_tenancy[$tenancy->tenancy_id] = [];
            if(Auth::user()->can('manage-users', $tenancy->tenancy_id)){
                $users_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->users;
            }
            if(Auth::user()->can('manage-teams', $tenancy->tenancy_id)){
                $teams_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->teams;
            }
            $stages_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->stages;
        }

        $listTeams          = $teams_by_tenancy;
        $listUsers          = $users_by_tenancy;
        $listStagesByTenancy     = $stages_by_tenancy;

        $listStages = \App\Models\Stage::getList();

        return view('customers.list-customers', compact(
                'listTeams',
                //'listWebsites',
                'listUsers',
                'listStages',
                /*'list_reason_finish',*/
                'tenancies',
                'listStagesByTenancy'
            ));
    }

    public function listAjax(Request $request){

        $customers          = Customer::getListByFilters($request);


        $listTeams          = []; //Team::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listUsers          = [] ;//User::where('tenancy_id', Auth::user()->tenancy_id)->get();


        foreach(Auth::user()->roles as $tenancy){

            $listTeams[$tenancy->tenancy_id] = [];
            $listUsers[$tenancy->tenancy_id] = [];
            if(Auth::user()->can('manage-users', $tenancy->tenancy_id)){
                $current_tenancy = Tenancy::find($tenancy->tenancy_id);
                $listTeams[$tenancy->tenancy_id] = $current_tenancy->teams;
                $listUsers[$tenancy->tenancy_id] = $current_tenancy->users;
            }
        }


        $listView = (request('setListView')?request('setListView'):'list-customers-default');
        $orderbyfield = "";
        $orderbyorder = "";

        if($request->orderbyfield AND $request->orderbyorder){
            $orderbyfield = $args->orderbyfield;
            $orderbyorder = $args->orderbyorder;
        }

        $dateIni = substr($request->filtro_data, 0, 10);
        $dateEnd =  substr($request->filtro_data, 22, 10);
        return view('customers.components.list-templates.'.$listView, compact('customers', 'orderbyfield', 'orderbyorder', 'listTeams', 'listUsers', 'dateIni', 'dateEnd'));
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

        $rel = $tenancy->users()->where('user_id', Auth::user()->id)->first();

        if(!$rel)
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar leads nesta empresa');

        if($request->team_id){
            $rel_team = $tenancy->teams()->where('id', $request->team_id)->first();
            if(!$rel_team)
                return redirect()->back()->with('error', 'Ops algo deu errado, a equipe e empresa selecionadas não batem.');
        }

        if($request->user_id){
            $rel_user = $tenancy->users()->where('user_id', $request->user_id)->first();
            if(!$rel_user)
                return redirect()->back()->with('error', 'Ops algo deu errado, o usuário e empresa selecionadas não batem.');
        }

        $stage = \App\Models\Stage::where('tenancy_id', Auth::user()->tenancy_id)->where('is_customer_default', true)->first();

        if(!$stage)
            return redirect()->back()->with('error', 'Não foi possível encontrar o estágio padrão de clientes');

        //die($request->source);
        $customer = Customer::create([
            'team_id' => $request->team_id,
            'source' => $request->source,
            'source_other' => $request->source_other,
            'user_id' => Auth::user()->hasAnyRoles(['basic'], $request->tenancy_id) ? Auth::user()->id : $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'ddd' => $request->ddd,
            'phone' => $request->phone,
            'ddd_2' => $request->ddd_2,
            'phone_2' => $request->phone_2,
            'tenancy_id' => $request->tenancy_id,
            'stage_id' => $stage->id,
            'new' => $stage->is_new,
            'real_state_project' => $request->real_state_project,
        ]);

        if($customer && $request->stage_id){
            $stage = \App\Models\Stage::where('tenancy_id',  $request->tenancy_id)->where('id', $request->stage_id)->first();

            if(!$stage)
                return redirect()->back()->with('error', 'Ops algo deu errado, o estágio e empresa selecionadas não batem.');

            $customer->updateStage($stage->id);
        }

        if($customer) {
            return redirect()->route('customers')->with('success','Lead adicionado!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao adicionar o lead.');
        }
    }

    public function redirect(Request $request, Customer $customer){
        $team = Team::find($request->team_id);
        $user = User::find($request->user_id);
        $customer->redirect($user?$user:false, $team?$team:false);
        return back()->with('success', 'Redirecionado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        $btn_end_customer_service = ( ($customer->customerService ? ( $customer->customerService->status == 1 or $customer->customerService->status == 2 ) : false) );
        $btn_start_customer_service = false; //( $customer->opened == 2 );
        $schedules = [
            1 => ($customer->customerService ? $customer->customerService->countScheduling(1) : 0),
            4 => ($customer->customerService ? $customer->customerService->countScheduling(4) : 0),
            5 => ($customer->customerService ? $customer->customerService->countScheduling(5) : 0)
            ];

        $list_reason_finish =  CustomerService::listStatusFinish($customer->tenancy_id);
        return view('customers.show-customer', compact('customer', 'btn_end_customer_service', 'btn_start_customer_service', 'schedules', 'list_reason_finish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->name                 = $request->name;
        $customer->email                = $request->email;
        $customer->whatsapp             = $request->whatsapp;
        $customer->ddd                  = $request->ddd;
        $customer->phone                = $request->phone;
        $customer->ddd_2                = $request->ddd_2;
        $customer->phone_2              = $request->phone_2;
        $customer->birth                = $request->birth;
        $customer->real_state_project   = $request->real_state_project;
        $customer->source               = $request->source;
        $customer->source_other         = $request->source_other;

        $customer->save();

        return back()->with('success', 'Alterações salvas!');
    }

    public function updateProductType(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->update(['product_type_id' => $request->product_type_id]);

        return back()->with('success', 'Alterações salvas!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $stage = \App\Models\Stage::where('tenancy_id', Auth::user()->tenancy_id)->where('is_deleted', true)->first();
        if(!$stage)
            return back()->with('error', 'Não foi possível encontrar a lixeira');

        $customer->updateStage($stage->id);
        $customer->save();

        return back()->with('success', 'Lead enviado para a lixeira');
    }

    public function listSales(){
        $customers = Customer::where([['stage_id', '>', '6'],['stage_id', '<', '10'], ['tenancy_id', '=', Auth::user()->tenancy_id]])->get();
        return view('customers.list-sales', compact('customers'));
    }
}
