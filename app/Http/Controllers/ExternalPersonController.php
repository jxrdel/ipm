<?php

namespace App\Http\Controllers;

use App\Models\ExternalPersons;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExternalPersonController extends Controller
{
    public function index()
    {
        return view('externalpersons');
    }

    public function getExternalPersons()
    {
        $query = ExternalPersons::all();

        return DataTables::of($query)->make(true);
    }
}
