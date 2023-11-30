<?php

namespace App\Livewire;

use App\Models\PermissionGroups;
use App\Models\PGroup;
use Livewire\Component;

class AddPermissionGroups extends Component
{
    public $pgroups;
    public $selectedPGroup;
    public $selectedPGroups = [];

    public function mount()
    {
        $this->pgroups = PGroup::orderBy('Name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.add-permission-groups');
    }

    public function addPermissionGroup()
    {
        $pgroupid = $this->selectedPGroup;
        $pgroup = PGroup::find($pgroupid);
        $pgroupname = $pgroup->Name;

        $this->selectedPGroups[] = ['pgroupid' => $pgroupid, 'pgroupname' => $pgroupname];

        session(['selectedPGroups' => $this->selectedPGroups]);

        $this->selectedPGroup = null;
    }

    public function removePermissionGroup($index)
    {
        unset($this->selectedPGroups[$index]);

        session(['selectedPGroups' => $this->selectedPGroups]);
    }
}
