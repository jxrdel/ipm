<?php

namespace App\Http\Controllers;

use App\Models\BusinessGroups;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use Illuminate\Http\Request;

class InternalContactController extends Controller
{
    public function index()
    {
        return view('listmohemployees');
    }
    public function newinternalcontact()
    {
        $roles = MOHRoles::all();
        $departments = BusinessGroups::all();

        return view('newic', compact('roles', 'departments'));
    }

    public function createInternalContact(Request $request)
    {

        dd($request);
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
