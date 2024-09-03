<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchases');
    }

    public function getPurchases()
    {

        $query = Purchases::join('ExternalContactCompanies', 'ExternalPurchases.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->join('ExternalPurchaseTypes', 'ExternalPurchases.ExternalPurchaseTypeId', '=', 'ExternalPurchaseTypes.ID')
            ->select('ExternalPurchases.*', 'ExternalContactCompanies.CompanyName as CompanyName', 'ExternalPurchaseTypes.Name as PTypeName');

        return DataTables::of($query)->make(true);
    }
}
