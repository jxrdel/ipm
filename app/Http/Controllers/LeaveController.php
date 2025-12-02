<?php

namespace App\Http\Controllers;

use App\Models\Leave;
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

        return DataTables::of($query)
            ->addColumn('internal_contact_name', function (Leave $leave) {
                return $leave->internalContact->Name . ' ' . $leave->internalContact->Surname;
            })
            ->make(true);
    }
}
