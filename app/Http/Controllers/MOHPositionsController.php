<?php

namespace App\Http\Controllers;

use App\Models\MOHRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MOHPositionsController extends Controller
{

    public function index()
    {
        $mohroles = MOHRoles::all();
        return view('listmohroles', compact('mohroles'));
    }

    public function getRoles()
    {

        $query = MOHRoles::all();

        return DataTables::of($query)->make(true);
    }
}
