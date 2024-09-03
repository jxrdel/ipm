<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AssociatedCompany extends Component
{
    public $companies;
    public $availablecompanies;
    public $selectedCompany;
    public $selectedCompanies = [];
    public $excludedCompanies = [];

    public function mount()
    {
        $this->companies = ExternalCompanies::all();
        $this->availablecompanies = ExternalCompanies::all();
    }

    public function render()
    {
        return view('livewire.associated-company');
    }

    public function addCompany()
    {
        $companyid = $this->selectedCompany;
        $company = ExternalCompanies::find($companyid);
        $compname = $company->CompanyName;
        $this->selectedCompanies[] = ['companyid' => $companyid, 'compname' => $compname, 'isactive' => 1, 'ismaincontact' => 0, 'isprimarycomp' => 0];

        //Remove company from drop down after it is selected
        $this->excludedCompanies = array_column($this->selectedCompanies, 'companyid');

        session(['selectedCompanies' => $this->selectedCompanies]);
        $this->selectedCompany = null;
    }

    public function removeCompany($index)
    {
        unset($this->selectedCompanies[$index]);

        //Remove company from drop down after it is selected
        $this->excludedCompanies = array_column($this->selectedCompanies, 'companyid');

        session(['selectedCompanies' => $this->selectedCompanies]);
    }

    public function toggleActive($index)
    {
        $newstate = $this->selectedCompanies[$index]['isactive'] == 1 ? 0 : 1;
        $this->selectedCompanies[$index]['isactive'] = $newstate;
        session(['selectedCompanies' => $this->selectedCompanies]);
    }

    public function toggleMainContact($index)
    {
        $newstate = $this->selectedCompanies[$index]['ismaincontact'] == 1 ? 0 : 1;
        $this->selectedCompanies[$index]['ismaincontact'] = $newstate;
        session(['selectedCompanies' => $this->selectedCompanies]);
    }

    public function togglePrimaryComp($index)
    {
        $newstate = $this->selectedCompanies[$index]['isprimarycomp'] == 1 ? 0 : 1;
        $this->selectedCompanies[$index]['isprimarycomp'] = $newstate;
        session(['selectedCompanies' => $this->selectedCompanies]);
    }

    public function insertCompanyAssociation($id)
    {

        foreach ($this->selectedCompanies as $company) {
            DB::table('ExternalContactPersonCompanies')->insert([
                'IsActive' => $company['isactive'],
                'IsPrimaryPerson' => $company['ismaincontact'],
                'IsPrimaryCompany' => $company['isprimarycomp'],
                'ExternalContactPersonId' => $id,
                'ExternalContactCompanyId' => $company['companyid'],
            ]);
        }

        session()->flush();
        $this->dispatch('close-create-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-create-success');
    }

    #[\Livewire\Attributes\On('reset-variables')]
    public function resetVariables()
    {
        $this->availablecompanies = null;
        $this->selectedCompany = null;
        $this->selectedCompanies = [];
        $this->excludedCompanies = [];
        session(['selectedCompanies' => $this->selectedCompanies]);
    }
}
