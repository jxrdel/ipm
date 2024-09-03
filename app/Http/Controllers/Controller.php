<?php

namespace App\Http\Controllers;

use App\Models\EmployeeContracts;
use App\Models\PurchaseContracts;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $employeeContractCount = array_fill_keys(range(1, 12), 0);
        $purchaseContractCount = array_fill_keys(range(1, 12), 0);

        $employeeContracts = EmployeeContracts::selectRaw('MONTH(EndDate) as month, count(*) as count')
            ->whereYear('EndDate', '=', date('Y'))
            ->groupBy(DB::raw('MONTH(EndDate)'))
            ->orderBy(DB::raw('MONTH(EndDate)'))
            ->pluck('count', 'month')
            ->toArray();

        foreach ($employeeContracts as $month => $count) {
            $employeeContractCount[$month] = $count;
        }

        $purchaseContracts = PurchaseContracts::selectRaw('MONTH(EndDate) as month, count(*) as count')
            ->whereYear('EndDate', '=', date('Y'))
            ->groupBy(DB::raw('MONTH(EndDate)'))
            ->orderBy(DB::raw('MONTH(EndDate)'))
            ->pluck('count', 'month')
            ->toArray();


        foreach ($purchaseContracts as $month => $count) {
            $purchaseContractCount[$month] = $count;
        }
            // dump($purchaseContracts);
        return view('home', compact('employeeContractCount', 'purchaseContractCount'));
    }

    public function login(){
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
