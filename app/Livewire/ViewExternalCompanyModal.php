<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewExternalCompanyModal extends Component
{
    public $compname;
    public $email;
    public $address1;
    public $address2;
    public $phone1;
    public $phone2;
    public $note;
    public $isactive = true;

    public $empassociations;
    public $associationcount;

    public function render()
    {
        return view('livewire.view-external-company-modal');
    }

    #[On('show-viewec-modal')]
    public function displayModal($id)
    {
        $company = ExternalCompanies::find($id);
        $this->compname = $company->CompanyName;
        $this->email = $company->Email;
        $this->address1 = $company->AddressLine1;
        $this->address2 = $company->AddressLine2;
        $this->phone1 = $company->Phone1;
        $this->phone2 = $company->Phone2;
        $this->note = $company->Details;
        $this->isactive = $company->IsActive;

        $empassociations = DB::table('ExternalContactPersonCompanies')
            ->where('ExternalContactCompanyId', $id)
            ->join('ExternalContactPersons', 'ExternalContactPersonCompanies.ExternalContactPersonId', '=', 'ExternalContactPersons.ID')
            ->select('ExternalContactPersonCompanies.*', 'ExternalContactPersons.FirstName as FirstName', 'ExternalContactPersons.LastName as LastName')
            ->get();

        $this->empassociations = $empassociations;

        $associationcount = DB::table('ExternalContactPersonCompanies')
            ->where('ExternalContactCompanyId', $id)
            ->join('ExternalContactPersons', 'ExternalContactPersonCompanies.ExternalContactPersonId', '=', 'ExternalContactPersons.ID')
            ->count();

        $this->associationcount = $associationcount;

        $this->dispatch('display-viewec-modal');
    }
}
