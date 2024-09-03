<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use Livewire\Component;

class CreateExternalCompanyModal extends Component
{
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
        return view('livewire.create-external-company-modal');
    }

    public function createExternalCompany()
    {
        $IsActive = $this->isactive == true ? 1 : 0;

        ExternalCompanies::create([
            'CompanyName' => $this->compname,
            'Email' => $this->email,
            'AddressLine1' => $this->address1,
            'AddressLine2' => $this->address2,
            'Phone1' => $this->phone1,
            'Phone2' => $this->phone2,
            'Details' => $this->note,
            'IsActive' => $IsActive,
        ]);

        $this->compname = null;
        $this->email = null;
        $this->address1 = null;
        $this->address2 = null;
        $this->phone1 = null;
        $this->phone2 = null;
        $this->note = null;
        $this->isactive = true;

        $this->dispatch('close-create-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-create-success');
    }
}
