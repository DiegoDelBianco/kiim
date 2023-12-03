<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Extension;

class ExtensionController extends Controller
{
    public function index()
    {
        $extensions = Extension::getExtensions();
        return view('extensions/list-extensions', compact('extensions'));
    }

    public function active(Request $request){

        $extension = Extension::getExtension($request->extension);
        if(!$request->extension && $extension)
            return back()->with('error', "Algo deu errado");

        $extension = Extension::updateOrCreate(
            ['extension' => $request->extension, 'tenancy_id' => Auth::user()->tenancy_id],
            [
                'active'                    => true,
                'tigger_view_home_all'      => isset($extension['tiggers']['view_home_all']),
                'tigger_view_menu_admin'    => isset($extension['tiggers']['view_menu_admin']),
                'tigger_monthend_close'     => isset($extension['tiggers']['monthend_close']),
            ]
        );
        return back()->with('error', "Extensão ativada com sucesso!");
    }

    public function disable(Request $request){

        if(!$request->extension && Extension::getExtension($request->extension))
            return back()->with('error', "Algo deu errado");

        $extension = Extension::updateOrCreate(
            ['extension' => $request->extension, 'tenancy_id' => Auth::user()->tenancy_id],
            ['active' => false]
        );
        return back()->with('error', "Extensão desativada com sucesso!");
    }
}
