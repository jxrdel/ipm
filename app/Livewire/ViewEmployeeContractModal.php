<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\EmployeeContracts;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewEmployeeContractModal extends Component
{
    public $employee;
    public $role;
    public $filenumber;
    public $filename;
    public $department;
    public $details;
    public $onlinelocation;
    public $manager;
    public $isperpetual = "true";
    public $startdate;
    public $enddate;
    public $monthsbefore = 1;
    public $empnotifications;
    public $contractdepartments;

    public $roles;
    public $managers;
    public $employees;
    public $departments;
    public $loggedinuser;

    public function mount()
    {
        $this->roles = MOHRoles::all();
        $this->managers = InternalContacts::all();
        $this->employees = InternalContacts::all();
        $this->departments = Departments::all();
        $this->loggedinuser = Auth::user()->internalcontact->ID;

    }

    public function render()
    {
        return view('livewire.view-employee-contract-modal');
    }
    #[On('show-viewec-modal')]
    public function displayModal($id)
    {
        $contract = EmployeeContracts::find($id);
        $contract = EmployeeContracts::where('EmployeeContracts.ID', $id)
        ->join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
        ->join('MOHRoles', 'EmployeeContracts.MOHRoleId', '=', 'MOHRoles.ID')
        ->join('BusinessGroups', 'EmployeeContracts.BusinessGroupId', '=', 'BusinessGroups.ID')
        ->select('EmployeeContracts.*', 'MOHRoles.Name as RoleName', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName', 'BusinessGroups.Name as Department')
        ->first();

        $this->employee = $contract->FirstName . ' ' . $contract->LastName;
        $this->role = $contract->RoleName;
        $this->filenumber = $contract->FileNumber;
        $this->filename = $contract->FileName;
        $this->details = $contract->Details;
        $this->onlinelocation = $contract->OnlineLocation;
        $this->manager = $contract->ManagerContactId;
        $this->manager = InternalContacts::find($contract->ManagerContactId);
        $this->manager = $this->manager->FirstName . ' ' . $this->manager->LastName;
        $this->department = $contract->Department;
        $this->isperpetual = $contract->IsPerpetual == 1 ? 'Perpetual' : 'End Date';
        $this->startdate = Carbon::parse($contract->StartDate)->format('d/m/Y');
        $this->enddate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        $this->dispatch('display-viewec-modal');
    }
}
