<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MOHRolesTable extends Component
{
    public $mohroles;
    // protected $listeners = ['refresh-table' => 'render'];

    public function mount()
    {
        $this->mohroles = DB::table('MOHRoles')->get();
    }

    #[\Livewire\Attributes\On('refresh_table')]
    public function render()
    {
        return view('livewire.m-o-h-roles-table');
    }
}
