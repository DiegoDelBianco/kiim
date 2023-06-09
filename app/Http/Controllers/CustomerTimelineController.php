<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerTimelineRequest;
use App\Http\Requests\UpdateCustomerTimelineRequest;
use Illuminate\Http\Request;
use App\Models\CustomerTimeline;
use App\Models\Customer;

class CustomerTimelineController extends Controller
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
    public function store(Request $request, Customer $customer)
    {
        $timeline = new CustomerTimeline;
        $timeline->newTimeline( $customer, $request->event, $request->type);

        return back()->with('success','Registro adicionado com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerTimeline $customerTimeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerTimeline $customerTimeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerTimelineRequest $request, CustomerTimeline $customerTimeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerTimeline $customerTimeline)
    {
        //
    }
}
