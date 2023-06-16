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

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listTeams          = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listWebsites       = Website::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listUsers          = User::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $list_reason_finish =  CustomerService::listStatusFinish();

        return view('customers.list-customers', compact(
                'listTeams',
                'listWebsites',
                'listUsers',
                'list_reason_finish'
            ));
    }

    public function listAjax(Request $request){

        $customers          = Customer::getListByFilters($request);
        $listTeams          = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();
        $listUsers          = User::where('tenancy_id', Auth::user()->tenancy_id)->get();

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
        $customer = Customer::create([
            'team_id' => $request->team_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'ddd' => $request->ddd,
            'phone' => $request->phone,
            'ddd_2' => $request->ddd_2,
            'phone_2' => $request->phone_2,
            'tenancy_id' => Auth::user()->tenancy_id,
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
            1 => ($customer->customer_service ? $customer->customer_service->countScheduling(1) : 0),
            4 => ($customer->customer_service ? $customer->customer_service->countScheduling(4) : 0),
            5 => ($customer->customer_service ? $customer->customer_service->countScheduling(5) : 0)
            ];
        return view('customers.show-customer', compact('customer', 'btn_end_customer_service', 'btn_start_customer_service', 'schedules'));
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
