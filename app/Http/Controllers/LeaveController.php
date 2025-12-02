<?php

namespace App\Http\Controllers;

use App\Enums\LeaveTypeEnum;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    public function index()
    {
        return view('leave');
    }

    public function getLeaves()
    {
        $query = Leave::with('internalContact');

        return $this->buildDatatable($query);
    }

    public function getUpcomingLeaves()
    {
        $query = Leave::with('internalContact')
            ->where('start_date', '>', Carbon::today());

        return $this->buildDatatable($query);
    }

    public function getOngoingLeaves()
    {
        $today = Carbon::today();
        $query = Leave::with('internalContact')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today);

        return $this->buildDatatable($query);
    }

    private function buildDatatable($query)
    {
        return DataTables::of($query)
            ->addColumn('leave_type_label', function (Leave $leave) {
                return LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() ?? $leave->leave_type;
            })
            ->filterColumn('leave_type_label', function($query, $keyword) {
                $query->where('leave_type', 'like', "%{$keyword}%");
            })
            ->addColumn('internal_contact_name', function (Leave $leave) {
                return $leave->internalContact->FirstName . ' ' . $leave->internalContact->LastName;
            })
            ->filterColumn('internal_contact_name', function($query, $keyword) {
                $query->whereHas('internalContact', function ($q) use ($keyword) {
                    $q->where('FirstName', 'like', "%{$keyword}%")
                      ->orWhere('LastName', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('start_date', function (Leave $leave) {
                return Carbon::parse($leave->start_date)->format('d-m-Y');
            })
            ->editColumn('end_date', function (Leave $leave) {
                return Carbon::parse($leave->end_date)->format('d-m-Y');
            })
            ->make(true);
    }
}
