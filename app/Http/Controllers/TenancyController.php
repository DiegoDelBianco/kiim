<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenancyRequest;
use App\Http\Requests\UpdateTenancyRequest;
use App\Models\Tenancy;
use App\Models\SysProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TenancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenancy                = Auth::user()->tenancy;
        $products               = SysProduct::all();
        $current_products       = Auth::user()->tenancy->sysProductTenancy;

        return view('tenancies.index', compact('tenancy', 'products', 'current_products'));
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
    public function store(StoreTenancyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenancy $tenancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenancy $tenancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'min:3', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            //'logo',
            //'max_users',
            //'max_websites',
            //'max_customers',
            //'user_id',
            'doc'               => ['required', 'max:18'],
            'phone'             => ['required', 'max:18'],
            'cep'               => ['required', 'max:9'],
            'address'           => ['required', 'max:255'],
            'address_number'    => ['nullable', 'max:10'],
            'complement'        => ['nullable', 'max:255'],
            'province'          => ['required', 'max:255'],
            'city'              => ['required', 'max:255'],
            'uf'                => ['required', 'max:2'],
        ]);

        $tenancy = Auth::user()->tenancy->update($request->all());

        if($tenancy) return back()->with('success', "Seus dados foram atualizados.");
        return back()->with('error', "Algo deu errado");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenancy $tenancy)
    {
        //
    }
}
