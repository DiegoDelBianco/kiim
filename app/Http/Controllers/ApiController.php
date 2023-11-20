<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function facebookConfig()
    {

        return view('api.facebook-config');
    }
}
