<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use Livewire\Attributes\On;
use Livewire\Component;

class EditExternalCompanyModal extends Component
{
    public $compid;
    public $compname;
    public $email;
    public $address1;
    public $address2;
    public $phone1;
    public $phone2;
    public $note;
    public $isactive = true;

    public function render()
    {
        return view('livewire.edit-external-company-modal');
    }

    #[On('show-editec-modal')]
    public function displayModal($id)
    {
        $company = ExternalCompanies::find($id);
        $this->compid = $company->ID;
        $this->compname = $company->CompanyName;
        $this->email = $company->Email;
        $this->address1 = $company->AddressLine1;
        $this->address2 = $company->AddressLine2;
        $this->phone1 = $company->Phone1;
        $this->phone2 = $company->Phone2;
        $this->note = $company->Details;
        $IsActive = $company->IsActive == 1 ? true : false;
        $this->isactive = $IsActive;
        $this->dispatch('display-editec-modal');
    }

    public function editExternalCompany()
    {

        $IsActive = $this->isactive == true ? 1 : 0;

        ExternalCompanies::where('ID', $this->compid)->update([
            'CompanyName' => $this->compname,
            'Email' => $this->email,
            'AddressLine1' => $this->address1,
            'AddressLine2' => $this->address2,
            'Phone1' => $this->phone1,
            'Phone2' => $this->phone2,
            'Details' => $this->note,
            'IsActive' => $IsActive,
        ]);

        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }
}
