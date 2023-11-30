<?php

namespace App\Livewire;

use App\Models\MOHRoles;
use Livewire\Component;

class CreateRoleModal extends Component
{
    public $mohrole;

    public function render()
    {
        return view('livewire.create-role-modal');
    }

    public function insertRole()
    {

        MOHRoles::create([
            'Name' => $this->mohrole,
        ]);

        $this->mohrole = null;
        $this->dispatch('close-create-modal');
        $this->dispatch('refresh_table');
        $this->dispatch('show-create-success');
    }
}
