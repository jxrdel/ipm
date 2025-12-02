<?php

namespace App\Http\Controllers;

use App\Models\EmployeeContracts;
use App\Models\PurchaseContracts;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $today = Carbon::today();
        $thisYear = $today->year;

        // Data for widgets
        $contractsEndingSoon = EmployeeContracts::where('EndDate', '>=', $today)->where('EndDate', '<=', $today->copy()->addMonths(4))->count()
                             + PurchaseContracts::where('EndDate', '>=', '2025-12-03 00:00:00.000')->where('EndDate', '<=', $today->copy()->addMonths(4))->count();

        $employeeContractsEndingThisYear = EmployeeContracts::whereYear('EndDate', $thisYear)->count();
        $purchaseContractsEndingThisYear = PurchaseContracts::whereYear('EndDate', $thisYear)->count();

        $contractsExpiringThisMonth = EmployeeContracts::with('internalcontact')
            ->whereYear('EndDate', $thisYear)
            ->whereMonth('EndDate', $today->month)
            ->get()
            ->map(function ($contract) {
                $contract->type = 'Employee';
                return $contract;
            })
            ->concat(
                PurchaseContracts::with('internalcontact')
                    ->whereYear('EndDate', $thisYear)
                    ->whereMonth('EndDate', $today->month)
                    ->get()
                    ->map(function ($contract) {
                        $contract->type = 'Purchase';
                        return $contract;
                    })
            );

        // Data for Bar Chart
        $employeeContractCounts = array_fill(1, 12, 0);
        $purchaseContractCounts = array_fill(1, 12, 0);

        $employeeContractsByMonth = EmployeeContracts::selectRaw('MONTH(EndDate) as month, count(*) as count')
            ->whereYear('EndDate', $thisYear)
            ->groupBy(DB::raw('MONTH(EndDate)'))
            ->pluck('count', 'month')
            ->all();

        $purchaseContractsByMonth = PurchaseContracts::selectRaw('MONTH(EndDate) as month, count(*) as count')
            ->whereYear('EndDate', $thisYear)
            ->groupBy(DB::raw('MONTH(EndDate)'))
            ->pluck('count', 'month')
            ->all();

        foreach ($employeeContractsByMonth as $month => $count) {
            $employeeContractCounts[$month] = $count;
        }
        foreach ($purchaseContractsByMonth as $month => $count) {
            $purchaseContractCounts[$month] = $count;
        }

        // Data for Table
        $upcomingExpirationsTable = EmployeeContracts::with('internalcontact')
            ->where('EndDate', '>=', $today)
            ->whereYear('EndDate', $thisYear)
            ->get()
            ->map(function ($contract) {
                $contract->type = 'Employee';
                return $contract;
            })
            ->concat(
                PurchaseContracts::with('internalcontact')
                    ->where('EndDate', '>=', $today)
                    ->whereYear('EndDate', $thisYear)
                    ->get()
                    ->map(function ($contract) {
                        $contract->type = 'Purchase';
                        return $contract;
                    })
            )
            ->sortBy('EndDate');


        return view('home', [
            'contractsEndingSoon' => $contractsEndingSoon,
            'employeeContractsEndingThisYear' => $employeeContractsEndingThisYear,
            'purchaseContractsEndingThisYear' => $purchaseContractsEndingThisYear,
            'contractsExpiringThisMonth' => $contractsExpiringThisMonth,
            'employeeContractCounts' => $employeeContractCounts,
            'purchaseContractCounts' => $purchaseContractCounts,
            'upcomingExpirationsTable' => $upcomingExpirationsTable
        ]);
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
