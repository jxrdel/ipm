<?php

namespace App\Http\Controllers;

use App\Enums\LeaveTypeEnum;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Data for widgets
        $upcomingLeaves = Leave::with('internalContact')
            ->where('start_date', '>', $today)
            ->where('start_date', '<=', $today->copy()->addDays(30))
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        $ongoingLeaves = Leave::with('internalContact')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        // Data for summary
        $totalApplicationsMonth = Leave::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->count();

        $mostCommonLeaveType = Leave::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->select('leave_type', DB::raw('count(*) as count'))
            ->groupBy('leave_type')
            ->orderByDesc('count')
            ->first();

        // Data for Calendar
        $allLeaves = Leave::with('internalContact')->get();
        $calendarEvents = $allLeaves->map(function ($leave) {
            $leaveTypeLabel = LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() ?? 'Unknown';
            $className = 'leave-' . strtolower(str_replace(' ', '-', $leaveTypeLabel));
            return [
                'id' => $leave->id,
                'title' => $leave->internalContact->FirstName . ' ' . $leave->internalContact->LastName,
                'start' => $leave->start_date,
                'end' => Carbon::parse($leave->end_date)->addDay()->toDateString(), // FullCalendar's end date is exclusive
                'classNames' => [$className],
                'extendedProps' => [
                    'type' => $leaveTypeLabel
                ]
            ];
        });

        // Data for Bar Chart (YTD)
        $leaveTypeStats = Leave::whereYear('created_at', $today->year)
            ->select('leave_type', DB::raw('SUM(days_to_be_taken) as total_days'))
            ->groupBy('leave_type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [LeaveTypeEnum::tryFrom($item->leave_type)?->getLabel() ?? $item->leave_type => $item->total_days];
            });

        return view('leave', [
            'upcomingLeaves' => $upcomingLeaves,
            'ongoingLeaves' => $ongoingLeaves,
            'totalApplicationsMonth' => $totalApplicationsMonth,
            'mostCommonLeaveType' => $mostCommonLeaveType?->leave_type,
            'calendarEvents' => $calendarEvents,
            'leaveTypeStats' => $leaveTypeStats,
        ]);
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
            ->filterColumn('leave_type_label', function ($query, $keyword) {
                $query->where('leave_type', 'like', "%{$keyword}%");
            })
            ->addColumn('internal_contact_name', function (Leave $leave) {
                return $leave->internalContact->FirstName . ' ' . $leave->internalContact->LastName;
            })
            ->filterColumn('internal_contact_name', function ($query, $keyword) {
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
