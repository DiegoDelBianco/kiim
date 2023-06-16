<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Models\SysProductTenancy;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, SysProductTenancy $sysProductTenancy)
    {
        if(!Auth::user()->tenancy->assas_id) return back()->with('error', 'Você tem um erro no seu cadastro, contate o desenvolvedor.');

        $payment = Payment::newSub($sysProductTenancy, $request->all());

        if(isset($payment['errors']))
            return redirect()->back()->with('error', $payment['errors'][0]->description);

        if(!isset($payment['status']))
            return redirect()->back()->with('error', 'Erro ao criar pagamento. #01');

        Payment::create([
                'credit_card_number'        => $payment['creditCard']->creditCardNumber,
                'credit_card_brand'         => $payment['creditCard']->creditCardBrand,
                //'credit_card_token'         => $payment['creditCard']->token,
                'status'                    => $payment['status'],
                'value'                     => $payment['value'],
                'totals'                    => $payment['value'],
                'sys_product_tenancy_id'    => $sysProductTenancy->id,
            ]);

        $sysProductTenancy->assas_sub_id = $payment['id'];
        $sysProductTenancy->save();

        if($payment['status'] != 'ACTIVE')
            return redirect()->back()->with('error', 'Erro ao criar pagamento. #02');

        $sysProductTenancy->activeProduct();


        return redirect()->back()->with('success', 'Pagamento realizado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
