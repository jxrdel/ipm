<?php

namespace App\Http\Controllers;

use App\Models\ExternalCompanies;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExternalCompanyController extends Controller
{
    public function index()
    {
        return view('externalcompanies');
    }

    public function getExternalCompanies()
    {

        $query = ExternalCompanies::all();

        return DataTables::of($query)->make(true);
    }
}
