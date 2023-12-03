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
            if(Auth::user()->can('manage-users', $tenancy->tenancy_id)){
                $users_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->users;
            }
            if(Auth::user()->can('manage-teams', $tenancy->tenancy_id)){
                $teams_by_tenancy[$tenancy->tenancy_id] = $current_tenancy->teams;
            }
        }

        $listTeams          = $teams_by_tenancy; //Team::where('tenancy_id', Auth::user()->tenancy_id)->get();
        //$listWebsites       = Website::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listUsers          = $users_by_tenancy; //User::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $list_reason_finish =  CustomerService::listStatusFinish();

        return view('customers.list-customers', compact(
                'listTeams',
                //'listWebsites',
                'listUsers',
                'list_reason_finish',
                'tenancies',
            ));
    }

    public function listAjax(Request $request){

        $customers          = Customer::getListByFilters($request);


        $listTeams          = []; //Team::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listUsers          = [] ;//User::where('tenancy_id', Auth::user()->tenancy_id)->get();


        foreach(Auth::user()->roles as $tenancy){

            $listTeams[$tenancy->tenancy_id] = null;
            $listUsers[$tenancy->tenancy_id] = null;
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


        return view('customers.components.list-templates.'.$listView, compact('customers', 'orderbyfield', 'orderbyorder', 'listTeams', 'listUsers'));
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
        //die($request->source);
        $customer = Customer::create([
            'team_id' => $request->team_id,
            'source' => $request->source,
            'source_other' => $request->source_other,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'ddd' => $request->ddd,
            'phone' => $request->phone,
            'ddd_2' => $request->ddd_2,
            'phone_2' => $request->phone_2,
            'tenancy_id' => $request->tenancy_id,
        ]);

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

        $list_reason_finish =  CustomerService::listStatusFinish();
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

        $customer->name             = $request->name;
        $customer->email            = $request->email;
        $customer->whatsapp         = $request->whatsapp;
        $customer->ddd              = $request->ddd;
        $customer->phone            = $request->phone;
        $customer->ddd_2            = $request->ddd_2;
        $customer->phone_2          = $request->phone_2;
        $customer->birth            = $request->birth;

        $customer->save();

        return back()->with('success', 'Alterações salvas!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->stage_id = 10;
        $customer->save();

        return back()->with('success', 'Lead enviado para a lixeira');
    }

    public function listSales(){
        $customers = Customer::where([['stage_id', '>', '6'],['stage_id', '<', '10'], ['tenancy_id', '=', Auth::user()->tenancy_id]])->get();
        return view('customers.list-sales', compact('customers'));
    }
}
