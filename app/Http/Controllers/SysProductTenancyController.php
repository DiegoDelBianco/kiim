<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSysProductTenancyRequest;
use App\Http\Requests\UpdateSysProductTenancyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\SysProductTenancy;
use App\Models\SysProduct;
use App\Models\Payment;

class SysProductTenancyController extends Controller
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
    public function store(Request $request, SysProduct $sysProduct)
    {
        $user = Auth::user()->tenancy;
        if(!Auth::user()->tenancy->doc) return redirect()->back()->with('error', 'Atualize seus dados em "Configurações" antes de continuar');
        $user_assas = $user->assas_id;

        if(!$user_assas){

            // Pesquisa por usuário no assas
            $user_assas = Payment::getUserByDoc($user->doc);

            // Verifica se retornou algum usuário
            // Se retornou algum usuário, pega o primeiro
            if($user_assas['totalCount']){
                $user_assas = $user_assas['data'][0]->id;
                $user->assas_id = $user_assas;
                $user->save();
                //echo 'Usuário criado no Assas, id:'.$user_assas['id'];

            // Caso não tenha retornado, cria um novo usuário
            }else{
                $user_assas = Payment::createAssasUser($user);
                print_r($user_assas);
                
                if(isset($user_assas['errors']))
                    return redirect()->back()->with('error', $user_assas['errors'][0]->description);
                if(!isset($user_assas['id']))
                    return redirect()->back()->with('error', 'Erro ao criar usuário no Assas');
                
                $user_assas = $user_assas['id'];
                $user->assas_id = $user_assas;
                $user->save();
                
            }
        }

        if(!$user_assas)
            return redirect()->back()->with('error', 'Houve algum erro');
        
        SysProductTenancy::create([
            'sys_product_id' => $sysProduct->id,
            'tenancy_id' => $user->id,
            'cycle' => $request->cycle,
        ]);
        
        // success, redirect to payment route 
        return redirect()->route('sysProduct', $sysProduct)->with('success', 'Contratação solicitada, siga para o pagamento');



        die();
    }

    /**
     * Display the specified resource.
     */
    public function show(SysProductTenancy $sysProductTenancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SysProductTenancy $sysProductTenancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSysProductTenancyRequest $request, SysProductTenancy $sysProductTenancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SysProductTenancy $sysProductTenancy)
    {
        //
    }
}
