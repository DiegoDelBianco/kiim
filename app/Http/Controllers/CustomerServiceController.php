<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerServiceRequest;
use App\Http\Requests\UpdateCustomerServiceRequest;
use Illuminate\Http\Request;
use App\Models\CustomerService;

class CustomerServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = CustomerService::currentCustomer(0);

        $btn_end_customer_service = NULL;
        $btn_start_customer_service = NULL;
        $schedules = [];
        $is_remarketing = false;
        $list_reason_finish = NULL;
        if($customer){
            $btn_end_customer_service = true;
            $btn_start_customer_service = false;
            $schedules = [
                1 => ($customer->customer_service ? $customer->customer_service->countScheduling(1) : 0),
                4 => ($customer->customer_service ? $customer->customer_service->countScheduling(4) : 0),
                5 => ($customer->customer_service ? $customer->customer_service->countScheduling(5) : 0)
                ];
            $list_reason_finish =  CustomerService::listStatusFinish();
        }
        return view('customers.show-customer-service', compact('customer', 'btn_end_customer_service', 'btn_start_customer_service', 'schedules', 'is_remarketing', 'list_reason_finish'));
    }

    public function indexRemarketing()
    {
        $customer = CustomerService::currentCustomer(1);

        $btn_end_customer_service = NULL;
        $btn_start_customer_service = NULL;
        $schedules = [];
        $is_remarketing = true;
        $list_reason_finish = NULL;
        if($customer){
            $btn_end_customer_service = true;
            $btn_start_customer_service = false;
            $schedules = [
                1 => ($customer->customer_service ? $customer->customer_service->countScheduling(1) : 0),
                4 => ($customer->customer_service ? $customer->customer_service->countScheduling(4) : 0),
                5 => ($customer->customer_service ? $customer->customer_service->countScheduling(5) : 0)
                ];
            $list_reason_finish =  CustomerService::listStatusFinish();
        }
        return view('customers.show-customer-service', compact('customer', 'btn_end_customer_service', 'btn_start_customer_service', 'schedules', 'is_remarketing', 'list_reason_finish'));
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
        $remarketing = false;
        if($request->has('remarketing')) $remarketing = $request->remarketing;

        $current = CustomerService::currentCustomer($remarketing);

        if($current) return back()->with('error','Finalize seu atendimento atual antes de iniciar outro');

        // inicia cadastro de novo atendimento
        $atendimento = new CustomerService;

        // Define próximo cliente, caso não exista retorna erro
        $cliente = $atendimento->nextCustomer($remarketing);

        if(isset($cliente['error'])) return back()->with('error', $cliente['error']);
        if(!$cliente) return back()->with('error', 'No momento não existem leads novos para atender.');

        // Inicia novo atendimento
        $result =  $atendimento->start(FALSE);

        return back()->with('success','Um novo Lead foi designado para você atender!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerService $customerService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerService $customerService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerServiceRequest $request, CustomerService $customerService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CustomerService $customer_service)
    {
        $this->authorize('delete', $customer_service);
        
        $customer_service->end($request->reason_finish, $request->description);


        // Atualiza cliente em caso de venda
        if($request->buy_date and ($request->reason_finish == 2)) 
            $customer_service->customer->buy_date = $request->buy_date;
        if($request->pay_date and ($request->reason_finish == 2)) 
            $customer_service->customer->pay_date = $request->pay_date;

        if(($request->buy_date or $request->pay_date) and ($request->reason_finish == 2))
            $customer_service->customer->save();
        

        return back()->with('success','Atendimento finalizado, agora você já pode atender outro lead!');
    }
}
