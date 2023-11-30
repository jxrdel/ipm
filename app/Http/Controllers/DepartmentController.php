<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Departments::join('BusinessGroupTypes', 'BusinessGroups.BusinessGroupTypeId', '=', 'BusinessGroupTypes.ID')
                ->select('BusinessGroups.*', 'BusinessGroupTypes.Name as BGTypeName')
                ->get();

            return view('listdepartments', compact('departments'));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function details($id)
    {
        $department = Departments::where('BusinessGroups.ID', $id)
            ->join('BusinessGroupTypes', 'BusinessGroups.BusinessGroupTypeId', '=', 'BusinessGroupTypes.ID')
            ->select('BusinessGroups.*', 'BusinessGroupTypes.Name as BGTypeName')
            ->first();

        $parentdept = null;
        if ($department->ParentId !== null) {
            $parentdept = Departments::find($department->ParentId);
            $parentdept = $parentdept->Name;
        }

        return view('departmentdetails', compact('department', 'parentdept'));
    }
    public function edit($id)
    {
        $department = Departments::where('BusinessGroups.ID', $id)
            ->join('BusinessGroupTypes', 'BusinessGroups.BusinessGroupTypeId', '=', 'BusinessGroupTypes.ID')
            ->select('BusinessGroups.*', 'BusinessGroupTypes.Name as BGTypeName')
            ->first();

        $bgtypes = DB::table('BusinessGroupTypes')->get();
        $alldepts = Departments::all();

        return view('editdepartment', compact('department', 'alldepts', 'bgtypes'));
    }

    public function update(Request $request)
    {
        $IsActive = $request->has('IsActive') ? 1 : 0;

        Departments::where('ID', $request->input('ID'))->update([
            'Name' => $request->input('Name'),
            'Abbreviation' => $request->input('Abbreviation'),
            'Details' => $request->input('Details'),
            'BusinessGroupTypeId' => $request->input('BusinessGroupTypeId'),
            'IsActive' => $IsActive,
            'ParentId' => $request->input('ParentId'),
        ]);

        return redirect()->route('listdepartments')->with('success', 'Department updated successfully.');
    }

    public function newDepartment(Request $request)
    {
        $bgtypes = DB::table('BusinessGroupTypes')->get();
        $alldepts = Departments::all();

        return view('newdepartment', compact('alldepts', 'bgtypes'));
    }

    public function createdept(Request $request)
    {

        Departments::create([
            'Name' => $request->input('Name'),
            'Abbreviation' => $request->input('Abbreviation'),
            'Details' => $request->input('Details'),
            'BusinessGroupTypeId' => $request->input('BusinessGroupTypeId'),
            'IsActive' => 1,
            'ParentId' => $request->input('ParentId'),
        ]);

        return redirect()->route('listdepartments')->with('success', 'Department created successfully.');
    }
}
