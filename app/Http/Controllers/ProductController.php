<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Tenancy;
use Gate;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenancies = [];
        foreach(Auth::user()->roles as $tenancy){
            //if(Auth::user()->can('manage-products', $tenancy->tenancy_id)){
                $tenancies[] = $tenancy->tenancy_id;
            //}
        }

        // select * from products where tenancy_id in $tenancies array
        $products = Product::whereIn('tenancy_id', $tenancies)->get();

        //$products = Product::where('tenancy_id', Auth::user()->tenancy_id)->get();
        return view('products.list-products', compact(
                'products'
            ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $tenancies = [];

        foreach(Auth::user()->roles as $tenancy){
            if(Auth::user()->can('manage-products', $tenancy->tenancy_id)){
                $current_tenancy = Tenancy::find($tenancy->tenancy_id);
                $tenancies[$tenancy->tenancy_id] = $current_tenancy;
            }
        }

        return view('products.create-product', compact('tenancies'));
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

        if(Gate::denies('manage-products', $tenancy->id))
            return redirect()->back()->with('error', 'Você não tem permissão para criar equipes nesta empresa');


        $product = Product::create(['title' => $request->title,
                'cep' => $request->cep,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'address' => $request->address,
                'description' => $request->description,
                'tenancy_id' => $request->tenancy_id]);


        if($product) {
            return redirect()->route('products')->with('success','Produto adicionado!');
        } else {
            return redirect()->back()->with('error', 'Houve algum erro ao adicionar o produto.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $this->authorize('view', $product);

        return view('products.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update(['title' => $request->title,
                'cep' => $request->cep,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'address' => $request->address,
                'description' => $request->description]);


        return redirect()->route('products')->with('success','Produto atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('update', $product);

        $product->delete();

        return back()->with('success','Imóvel removido!');
    }
}
