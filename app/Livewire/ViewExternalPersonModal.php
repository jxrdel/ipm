<?php

namespace App\Livewire;

use App\Models\ExternalPersons;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewExternalPersonModal extends Component
{
    public $firstname;
    public $lastname;
    public $othername;
    public $email;
    public $address1;
    public $address2;
    public $phone1;
    public $phone2;
    public $note;
    public $isactive = true;
    public $compassociations;
    public $associationcount;

    public function render()
    {
        return view('livewire.view-external-person-modal');
    }

    #[On('show-viewep-modal')]
    public function displayModal($id)
    {
        $person = ExternalPersons::find($id);
        $this->firstname = $person->FirstName;
        $this->lastname = $person->LastName;
        $this->othername = $person->OtherName;
        $this->email = $person->Email;
        $this->address1 = $person->AddressLine1;
        $this->address2 = $person->AddressLine2;
        $this->phone1 = $person->Phone1;
        $this->phone2 = $person->Phone2;
        $this->note = $person->Details;
        $this->isactive = $person->IsActive;

        $compassociations = DB::table('ExternalContactPersonCompanies')
            ->where('ExternalContactPersonId', $id)
            ->join('ExternalContactCompanies', 'ExternalContactPersonCompanies.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->select('ExternalContactPersonCompanies.*', 'ExternalContactCompanies.CompanyName as CompanyName')
            ->get();

        $this->compassociations = $compassociations;

        $associationcount = DB::table('ExternalContactPersonCompanies')
            ->where('ExternalContactPersonId', $id)
            ->join('ExternalContactCompanies', 'ExternalContactPersonCompanies.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->count();

        $this->associationcount = $associationcount;

        $this->dispatch('display-viewep-modal');
    }
}
