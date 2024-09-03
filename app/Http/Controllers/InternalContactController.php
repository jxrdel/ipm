<?php

namespace App\Http\Controllers;

use App\Models\BusinessGroups;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InternalContactController extends Controller
{
    public function index()
    {
        return view('listmohemployees');
    }

    public function getInternalContacts()
    {

        $query = InternalContacts::join('BusinessGroups', 'InternalContacts.BusinessGroupId', '=', 'BusinessGroups.ID')
            ->join('MOHRoles', 'InternalContacts.MOHRoleId', '=', 'MOHRoles.ID')
            ->select('InternalContacts.*', 'BusinessGroups.ID as BGID', 'BusinessGroups.Name as DepartmentName', 'MOHRoles.ID as RoleID', 'MOHRoles.Name as RoleName');

        return DataTables::of($query)->make(true);
    }

    public function newinternalcontact()
    {
        $roles = MOHRoles::orderBy('Name')->get();
        $departments = BusinessGroups::all();

        return view('newic', compact('roles', 'departments'));
    }

    public function createInternalContact(Request $request)
    {

        InternalContacts::create([
            'IsActive' => 1,
            'FirstName' => $request->input('FirstName'),
            'LastName' => $request->input('LastName'),
            'Email' => $request->input('Email'),
            'PhoneExt' => $request->input('PhoneExt'),
            'BusinessGroupId' => $request->input('BusinessGroupId'),
            'MOHRoleId' => $request->input('MOHRoleId'),
        ]);

        return redirect()->route('listinternalcontacts')->with('success', 'Role added successfully.');
    }
}
