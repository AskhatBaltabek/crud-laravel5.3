<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __construct ()
    {
        
    }

    public function home (Request $request)
    {
        
        return view('pages.index');
    }
}