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

class EditEmployeeContractModal extends Component
{
    public $contractid;
    public $employee;
    public $role;
    public $filenumber;
    public $filename;
    public $details;
    public $onlinelocation;
    public $manager;
    public $department;
    public $startdate;
    public $enddate;
    public $isperpetual;

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
        return view('livewire.edit-employee-contract-modal');
    }

    #[On('show-editec-modal')]
    public function displayModal($id)
    {
        $contract = EmployeeContracts::find($id);
        $contract = EmployeeContracts::where('EmployeeContracts.ID', $id)
        ->join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
        ->join('MOHRoles', 'EmployeeContracts.MOHRoleId', '=', 'MOHRoles.ID')
        ->join('BusinessGroups', 'EmployeeContracts.BusinessGroupId', '=', 'BusinessGroups.ID')
        ->select('EmployeeContracts.*', 'MOHRoles.Name as RoleName', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName', 'BusinessGroups.Name as Department')
        ->first();

        $this->contractid = $contract->ID;
        $this->employee = $contract->EmployeeContactId;
        $this->role = $contract->MOHRoleId;
        $this->filenumber = $contract->FileNumber;
        $this->filename = $contract->FileName;
        $this->details = $contract->Details;
        $this->onlinelocation = $contract->OnlineLocation;
        $this->manager = $contract->ManagerContactId;
        $this->department = $contract->BusinessGroupId;
        $this->isperpetual = $contract->IsPerpetual == 1 ? true : false;
        // dd($this->isperpetual);
        $this->startdate = Carbon::parse($contract->StartDate)->format('Y-m-d');
        $this->enddate = Carbon::parse($contract->EndDate)->format('Y-m-d');
        $this->dispatch('display-editec-modal');
    }

    public function editEC(){
        // dd($this->manager);

        EmployeeContracts::where('ID', $this->contractid)->update([
            'Details' => $this->details,
            'FileNumber' => $this->filenumber,
            'FileName' => $this->filename,
            'OnlineLocation' => $this->onlinelocation,
            'StartDate' => $this->startdate,
            'EndDate' => $this->enddate,
            'EmployeeContactId' => $this->employee,
            'MOHRoleId' => $this->role,
            'BusinessGroupId' => $this->department,
            'ManagerContactId' => $this->manager
        ]);
        
        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }
}
