<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Website;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $websites = Website::where('tenancy_id', Auth::user()->tenancy_id)->get();
        return view('websites.list-websites', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $templates = Website::getTemplateList();
        return view('websites.create-website', compact('product', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $website = Website::create([
            'name' => $request->name,
            'template' => $request->template,
            'product_id' => $product->id,
            'tenancy_id' => Auth::user()->tenancy_id
        ]);

        if($website) {
            return redirect()->route('websites.edit', $website);
        } else {
            return redirect()->back()->with('error', 'Houve algum erro a leadpage.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {

        // Obtem parametros do arquivo de configuração
        //$params = Website::getData($user, $leadpage);

        // Exibe a leadpage
        return view("websites.templates.".$website->template.".index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        return view('websites.edit-website', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        //
    }
}
