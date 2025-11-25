<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }
    
    public function teste()
    {
        return 'CONTROLLER FUNCIONOU!';
    }
}
