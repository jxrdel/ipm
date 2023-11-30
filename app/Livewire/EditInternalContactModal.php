<?php

namespace App\Livewire;

use App\Models\BusinessGroups;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class EditInternalContactModal extends Component
{
    public $employeeid;
    public $firstname;
    public $lastname;
    public $email;
    public $role;
    public $department;
    public $isactive;
    public $extno;

    public function render()
    {
        $roles = MOHRoles::all();
        $departments = BusinessGroups::all();
        return view('livewire.edit-internal-contact-modal', compact('roles', 'departments'));
    }

    #[On('show-editic-modal')]
    public function displayModal($id)
    {
        $employee = InternalContacts::find($id);
        $this->employeeid = $employee->ID;
        $this->firstname = $employee->FirstName;
        $this->lastname = $employee->LastName;
        $this->email = $employee->Email;
        $this->role = $employee->MOHRoleId;
        $this->department = $employee->BusinessGroupId;
        $IsActive = $employee->IsActive == 1 ? true : false;
        $this->isactive = $IsActive;
        $this->extno = $employee->PhoneExt;
        $this->dispatch('display-editic-modal');
    }

    public function editEmployee()
    {
        $IsActive = $this->isactive == true ? 1 : 0;

        try {
            InternalContacts::where('ID', $this->employeeid)->update([
                'FirstName' => $this->firstname,
                'LastName' => $this->lastname,
                'Email' => $this->email,
                'MOHRoleId' => $this->role,
                'BusinessGroupId' => $this->department,
                'IsActive' => $IsActive,
                'PhoneExt' => $this->extno,
            ]);
            $this->dispatch('close-edit-modal');
            $this->dispatch('refresh-table');
            $this->dispatch('show-edit-success');
        } catch (Exception $e) {
            dd($e);
        }
    }
}
