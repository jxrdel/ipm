<?php

namespace App\Livewire;

use App\Models\Roles;
use Illuminate\Http\Request;
use Livewire\Component;

class RoleList extends Component
{
    public $roles;
    public $selectedRole;
    public $selectedRoles = [];

    public function mount()
    {
        $this->roles = Roles::all();
    }

    public function render()
    {
        $availableroles = $this->roles->reject(function ($user) {
            // dd(in_array(['roleid' => $user->id], $this->selectedRoles));
            return in_array(['roleid' => $user->id], $this->selectedRoles);
        });
        return view('livewire.role-list', compact('availableroles'));
    }

    public function addRole()
    {
        $roleid = $this->selectedRole;
        $role = Roles::find($roleid);
        $rolename = $role->Name;
        $this->selectedRoles[] = ['roleid' => $roleid, 'rolename' => $rolename];

        session(['selectedRoles' => $this->selectedRoles]);

        $this->selectedRole = null;
    }

    public function removeRole($index)
    {
        unset($this->selectedRoles[$index]);

        session(['selectedRoles' => $this->selectedRoles]);
    }
}
