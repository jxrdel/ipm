<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MOHPositionsController extends Controller
{

    public function index()
    {
        return view('listmohroles');
    }
}
