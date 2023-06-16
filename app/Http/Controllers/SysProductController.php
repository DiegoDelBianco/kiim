<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSysProductRequest;
use App\Http\Requests\UpdateSysProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\SysProduct;

class SysProductController extends Controller
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
    public function store(StoreSysProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SysProduct $sysProduct)
    {
        $contract = Auth::user()->tenancy->sysProductTenancy->where('sys_product_id', $sysProduct->id)->first();
        
        return view('sys-products.show-sys-product', compact('sysProduct', 'contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SysProduct $sysProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSysProductRequest $request, SysProduct $sysProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SysProduct $sysProduct)
    {
        //
    }
}
