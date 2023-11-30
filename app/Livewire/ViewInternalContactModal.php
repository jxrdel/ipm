<?php

namespace App\Livewire;

use App\Models\InternalContacts;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewInternalContactModal extends Component
{
    public $firstname;
    public $lastname;
    public $email;
    public $role;
    public $department;
    public $isactive;
    public $extno;
    public $contractcount;
    public $contracts;

    public function render()
    {
        return view('livewire.view-internal-contact-modal');
    }

    #[On('show-viewic-modal')]
    public function displayModal($id)
    {
        $employee = InternalContacts::where('InternalContacts.ID', $id)
            ->join('BusinessGroups', 'InternalContacts.BusinessGroupId', '=', 'BusinessGroups.ID')
            ->join('MOHRoles', 'InternalContacts.MOHRoleId', '=', 'MOHRoles.ID')
            ->select('InternalContacts.*', 'BusinessGroups.Name as BGName', 'MOHRoles.Name as RoleName')
            ->first();

        $employeecontracts = DB::table('EmployeeContracts')
            ->where('EmployeeContactId', $id)
            ->get();
        $this->contracts = $employeecontracts;

        $contractcount = DB::table('EmployeeContracts')
            ->where('EmployeeContactId', $id)
            ->count();
        $this->contractcount = $contractcount;

        $this->firstname = $employee->FirstName;
        $this->lastname = $employee->LastName;
        $this->email = $employee->Email;
        $this->role = $employee->RoleName;
        $this->department = $employee->BGName;
        $this->isactive = $employee->IsActive;
        $this->extno = $employee->PhoneExt;
        $this->dispatch('display-viewic-modal');
    }
}
