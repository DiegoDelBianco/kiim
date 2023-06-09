<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenancyRequest;
use App\Http\Requests\UpdateTenancyRequest;
use App\Models\Tenancy;

class TenancyController extends Controller
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
    public function update(UpdateTenancyRequest $request, Tenancy $tenancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenancy $tenancy)
    {
        //
    }
}
