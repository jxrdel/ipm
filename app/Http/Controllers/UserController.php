<?php

namespace App\Http\Controllers;

use App\Models\BusinessGroups;
use App\Models\InternalContacts;
use App\Models\MenuHeaders;
use App\Models\MOHRoles;
use App\Models\PermissionGroups;
use App\Models\PGroup;
use App\Models\Roles;
use App\Models\UserPermissions;
use App\Models\UserRoles;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = Users::all();
        return view('listusers', compact('users'));
    }

    public function newUser()
    {
        $internalcontacts = InternalContacts::orderBy('FirstName', 'asc')->get();
        $roles = Roles::all();
        return view('newuser', compact('internalcontacts', 'roles'));
    }

    public function createUser(Request $request)
    {
        $IsActive = $request->has('IsActive') ? 1 : 0;

        $now = Carbon::now();
        $now = $now->format('Y-m-d H:i:s');

        $selectedRoles = $request->session()->get('selectedRoles', []);
        $selectedPGroups = $request->session()->get('selectedPGroups', []);
        $selectedPermissions = $request->session()->get('selectedPermissions', []);

        $newuser = Users::create([
            'Name' => $request->input('username'),
            'IsActive' => $IsActive,
            'UsrRolePermTimestamp' => $now,
            'IsSysAdmin' => 0,
            'InternalContactId' => $request->input('InternalContactId'),
        ]);

        foreach ($selectedRoles as $role) {
            UserRoles::create([
                'UserId' => $newuser->ID,
                'RoleId' => $role['roleid'],
                'IsPrimary' => 0,
            ]);
        }

        foreach ($selectedPGroups as $pgroup) {
            PermissionGroups::create([
                'UserId' => $newuser->ID,
                'PermissionGroupId' => $pgroup['pgroupid'],
            ]);
        }

        foreach ($selectedPermissions as $permission) {
            UserPermissions::create([
                'UserId' => $newuser->ID,
                'PermissionId' => $permission['permissionid'],
            ]);
        }

        session()->flush();
        return redirect()->route('listusers')->with('success', 'User created successfully.');
    }

    public function details($id)
    {
        $user = Users::find($id);
        $internalcontact = InternalContacts::find($user->InternalContactId);
        $roles = DB::table('RoleAlloweds')
            ->join('Roles', 'RoleAlloweds.RoleId', '=', 'Roles.ID')
            ->select('RoleAlloweds.RoleId as ID', 'Roles.Name')
            ->where('UserId', $id)
            ->get();

        $permissiongroups = DB::table('PermissionGroupAlloweds')
            ->join('PermissionGroups', 'PermissionGroupAlloweds.PermissionGroupId', '=', 'PermissionGroups.ID')
            ->select('PermissionGroupAlloweds.PermissionGroupId as PermissionID', 'PermissionGroups.Name as Name')
            ->where('UserId', $id)
            ->get();

        $specificpermissions = DB::table('PermissionAlloweds')
            ->join('Permissions', 'PermissionAlloweds.PermissionId', '=', 'Permissions.ID')
            ->select('PermissionAlloweds.PermissionId as spID', 'Permissions.Description as Description')
            ->where('UserId', $id)
            ->get();

        $menuheaders = DB::table('RoleNavMenuHeaders')
            ->join('NavMenuHeaders', 'RoleNavMenuHeaders.HeaderId', '=', 'NavMenuHeaders.ID')
            ->select('RoleNavMenuHeaders.ID as ID', 'NavMenuHeaders.Label as Label')
            ->where('RoleId', $id)
            ->get();

        $menuheaders = MenuHeaders::where('UserId', $id)
            ->distinct('Label')
            ->pluck('Label');



        $variables = compact('user', 'internalcontact', 'roles', 'permissiongroups', 'specificpermissions', 'menuheaders');
        return view('userdetails', $variables);
    }

    public function edit($id)
    {
        $user = Users::find($id);
        $internalcontacts = InternalContacts::all();
        $allroles = Roles::all();
        $availableroles = $allroles->diff($user->roles);

        $roles = DB::table('RoleAlloweds')
            ->join('Roles', 'RoleAlloweds.RoleId', '=', 'Roles.ID')
            ->select('RoleAlloweds.ID as ID', 'RoleAlloweds.UserId as UserId', 'RoleAlloweds.RoleId as RoleId', 'Roles.Name')
            ->where('UserId', $id)
            ->get();

        $specificpermissions = DB::table('PermissionAlloweds')
            ->join('Permissions', 'PermissionAlloweds.PermissionId', '=', 'Permissions.ID')
            ->select('PermissionAlloweds.PermissionId as spID', 'Permissions.Description as Description')
            ->where('UserId', $id)
            ->get();

        $menuheaders = MenuHeaders::where('UserId', $id)
            ->distinct('Label')
            ->pluck('Label');

        $permissiongroups = DB::table('PermissionGroupAlloweds')
            ->join('PermissionGroups', 'PermissionGroupAlloweds.PermissionGroupId', '=', 'PermissionGroups.ID')
            ->select('PermissionGroupAlloweds.ID as ID', 'PermissionGroupAlloweds.PermissionGroupId as PermissionID', 'PermissionGroups.Name as Name')
            ->where('UserId', $id)
            ->get();


        $allgroups = PGroup::all();
        $availablegroups = $allgroups->diff($user->permissiongroups);


        $variables = compact('user', 'internalcontacts', 'roles', 'specificpermissions', 'menuheaders', 'allroles', 'availableroles', 'permissiongroups', 'availablegroups');
        return view('edituser', $variables);
    }

    public function updateUser(Request $request)
    {
        $IsActive = $request->has('IsActive') ? 1 : 0;

        Users::where('ID', $request->input('userID'))->update([
            'IsActive' => $IsActive,
            'InternalContactId' => $request->input('InternalContactId'),
        ]);

        return redirect()->route('listusers')->with('success', 'User details saved successfully.');
    }

    public function addRole(Request $request, $id)
    {
        UserRoles::create([
            'UserId' => $id,
            'RoleId' => $request->input('RoleId'),
            'IsPrimary' => 0,
        ]);

        return redirect()->route('edituser', ['id' => $id])->with('success', 'Role added successfully.');
    }

    public function deleteRole($id, $userid)
    {
        $userRole = UserRoles::find($id);

        $userRole->delete();

        return redirect()->route('edituser', ['id' => $userid])->with('success', 'Role deleted successfully.');
    }

    public function addPGroup(Request $request, $id)
    {
        PermissionGroups::create([
            'UserId' => $id,
            'PermissionGroupId' => $request->input('GroupID'),
        ]);

        return redirect()->route('edituser', ['id' => $id])->with('success', 'Permission group added successfully.');
    }

    public function deletePGroup($id, $userid)
    {
        $permissiongroup = PermissionGroups::find($id);

        $permissiongroup->delete();

        return redirect()->route('edituser', ['id' => $userid])->with('success', 'Permission group deleted successfully.');
    }
}
