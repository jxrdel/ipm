<?php

namespace App\Http\Controllers;

use App\Models\EmployeeContracts;
use App\Models\PurchaseContracts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
{
    public function purchaseContracts()
    {
        return view('purchasecontracts');
    }

    public function getPurchaseContracts()
    {
        $query = PurchaseContracts::all();

        $query->each(function ($contract) {
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function getActivePurchaseContracts()
    {
        $query = PurchaseContracts::whereDate('EndDate', '>=', Carbon::today())->get();

        $query->each(function ($contract) {
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function getInactivePurchaseContracts()
    {
        $query = PurchaseContracts::whereDate('EndDate', '<', Carbon::today())->get();

        $query->each(function ($contract) {
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function setIC(Request $request)
    {
        $myArray = $request->input('internalContacts');
    }

    public function employeeContracts()
    {
        return view('employeecontracts');
    }

    public function getEmployeeContracts()
    {
        $query = EmployeeContracts::join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
            ->select('EmployeeContracts.*', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName')
            ->get();

        $query->each(function ($contract) {
            $contract->EmployeeName = $contract->FirstName . ' ' . $contract->LastName;
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function getActiveEmployeeContracts()
    {
        $query = EmployeeContracts::join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
            ->select('EmployeeContracts.*', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName')
            ->whereDate('EndDate', '>=', Carbon::today())
            ->get();

        $query->each(function ($contract) {
            $contract->EmployeeName = $contract->FirstName . ' ' . $contract->LastName;
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function getInactiveEmployeeContracts()
    {
        $query = EmployeeContracts::join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
            ->select('EmployeeContracts.*', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName')
            ->whereDate('EndDate', '<', Carbon::today())
            ->get();

        $query->each(function ($contract) {
            $contract->EmployeeName = $contract->FirstName . ' ' . $contract->LastName;
            $contract->FormattedStartDate = Carbon::parse($contract->StartDate)->format('d/m/Y');
            $contract->FormattedEndDate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }

    public function downloadActiveEmployeeContracts()
    {
        $now = now();
        $fileName = "active-contracts-{$now->format('Y-m-d_H-i-s')}.csv";

        $records = EmployeeContracts::join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
            ->join('BusinessGroups', 'EmployeeContracts.BusinessGroupId', '=', 'BusinessGroups.ID')
            ->join('MOHRoles', 'EmployeeContracts.MOHRoleId', '=', 'MOHRoles.ID')
            ->select('EmployeeContracts.*', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName', 'BusinessGroups.Name as Unit', 'MOHRoles.Name as Position')
            ->whereDate('EndDate', '>=', Carbon::today())
            ->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');

            // Add CSV header with the specified column names
            fputcsv($file, ['Employee Name', 'Unit', 'Position', 'Start Date', 'End Date', 'Time Remaining']);

            // Add records
            foreach ($records as $record) {
                fputcsv($file, [
                    $record->FirstName . ' ' . $record->LastName,
                    $record->Unit,
                    $record->Position,
                    Carbon::parse($record->StartDate)->format('d/m/Y'),
                    Carbon::parse($record->EndDate)->format('d/m/Y'),
                    Carbon::now()->diffInMonths($record->EndDate) . ' months ' . Carbon::now()->diffInDays($record->EndDate) . ' days',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
