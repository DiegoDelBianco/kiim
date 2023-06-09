<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('tenancy_id', Auth::user()->tenancy_id)->get();
        return view('products.list-products', compact(
                'products'
            ));    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create-product');    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create(['title' => $request->title,
                'cep' => $request->cep,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'address' => $request->address,
                'description' => $request->description,
                'tenancy_id' => Auth::user()->tenancy_id]);


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
        return view('products.edit-product', compact('product'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update(['title' => $request->title,
                'cep' => $request->cep,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'address' => $request->address,
                'description' => $request->description,
                'tenancy_id' => Auth::user()->tenancy_id]);


        return redirect()->route('products')->with('success','Produto atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
