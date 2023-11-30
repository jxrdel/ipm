<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MOHRolesTable extends Component
{
    public $mohroles;
    protected $listeners = ['refresh_table' => 'render'];

    public function mount()
    {
        $this->mohroles = DB::table('MOHRoles')->get();
    }

    public function render()
    {
        return view('livewire.m-o-h-roles-table');
    }
}
