<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use App\Models\ExternalPersons;
use Livewire\Component;

class EditAssociatedCompanies extends Component
{
    public $personid;
    public $companies;
    public $selectedCompany;
    public $selectedCompanies = [];
    public $excludedCompanies = [];

    public function mount($personid = null)
    {
        $this->personid = $personid;
        // dd($personid);
        $this->companies = ExternalCompanies::all();
    }

    public function render()
    {
        return view('livewire.edit-associated-companies');
    }
}
