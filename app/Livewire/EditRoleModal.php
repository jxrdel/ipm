<?php

namespace App\Livewire;

use App\Models\MOHRoles;
use Livewire\Attributes\On;
use Livewire\Component;

class EditRoleModal extends Component
{
    public $mohroleid;
    public $mohrole;

    public function render()
    {
        return view('livewire.edit-role-modal');
    }

    #[On('show-edit-modal')]
    public function displayModal($roleid)
    {
        $role = MOHRoles::find($roleid);
        $rolename = $role->Name;
        $this->mohroleid = $roleid;
        $this->mohrole = $rolename;
        $this->dispatch('display-edit-modal');
        // dd($rolename);
    }

    public function editRole()
    {
        MOHRoles::where('ID', $this->mohroleid)->update([
            'Name' => $this->mohrole,
        ]);
        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }
}
