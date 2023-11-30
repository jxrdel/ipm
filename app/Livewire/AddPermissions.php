<?php

namespace App\Livewire;

use App\Models\Permissions;
use App\Models\permission;
use Livewire\Component;

class AddPermissions extends Component
{
    public $permissions;
    public $selectedPermission;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->permissions = Permissions::orderBy('Description', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.add-permissions');
    }

    public function addPermission()
    {
        $permissionid = $this->selectedPermission;
        $permission = Permissions::find($permissionid);
        $permissionname = $permission->Description;

        $this->selectedPermissions[] = ['permissionid' => $permissionid, 'permissionname' => $permissionname];

        session(['selectedPermissions' => $this->selectedPermissions]);

        $this->selectedPermission = null;
    }

    public function removePermission($index)
    {
        unset($this->selectedPermissions[$index]);

        session(['selectedPermissions' => $this->selectedPermissions]);
    }
}
