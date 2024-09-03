<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use App\Models\ExternalPersons;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditExternalPersonModal extends Component
{
    public $personid;
    public $firstname;
    public $lastname;
    public $othername;
    public $email;
    public $address1;
    public $address2;
    public $phone1;
    public $phone2;
    public $note;
    public $isactive;
    public $compassociations = [];
    public $excludedCompanies = [];
    public $selectedcompany;
    public $companiestodelete = [];
    

    public $companies;

    public function mount()
    {
        $this->companies = ExternalCompanies::all();
    }

    public function render()
    {
        return view('livewire.edit-external-person-modal');
    }
    #[On('show-editep-modal')]
    public function displayModal($id)
    {
        $person = ExternalPersons::find($id);
        $this->personid = $person->ID;
        $this->firstname = $person->FirstName;
        $this->lastname = $person->LastName;
        $this->othername = $person->OtherName;
        $this->email = $person->Email;
        $this->address1 = $person->AddressLine1;
        $this->address2 = $person->AddressLine2;
        $this->phone1 = $person->Phone1;
        $this->phone2 = $person->Phone2;
        $this->note = $person->Details;
        $IsActive = $person->IsActive == 1 ? true : false;
        $this->isactive = $IsActive;
        $this->companiestodelete = [];
        $this->excludedCompanies = [];

        $compassociations = DB::table('ExternalContactPersonCompanies')
            ->where('ExternalContactPersonId', $this->personid)
            ->join('ExternalContactCompanies', 'ExternalContactPersonCompanies.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->select('ExternalContactPersonCompanies.*', 'ExternalContactCompanies.CompanyName as CompanyName')
            ->get();

        $this->compassociations = $compassociations->toArray();
        $this->compassociations = json_decode(json_encode($this->compassociations), true);

        //Remove option to add companies that are already selected
        $this->excludedCompanies = array_column($this->compassociations, 'ExternalContactCompanyId');
        // dd($this->compassociations);

        $this->dispatch('display-editep-modal');
    }

    public function editExternalPerson()
    {
        $IsActive = $this->isactive == true ? 1 : 0;
        // dd($IsActive);

        ExternalPersons::where('ID', $this->personid)->update([
            'FirstName' => $this->firstname,
            'LastName' => $this->lastname,
            'OtherName' => $this->othername,
            'Email' => $this->email,
            'AddressLine1' => $this->address1,
            'AddressLine2' => $this->address2,
            'Phone1' => $this->phone1,
            'Phone2' => $this->phone2,
            'Details' => $this->note,
            'IsActive' => $IsActive,
        ]);

        //Delete associated companies
        foreach ($this->companiestodelete as $company){
            if($company['ID'] !== null){ //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('ExternalContactPersonCompanies')
                ->where('ID', $company['ID'])
                ->delete();
            }
        }

        foreach ($this->compassociations as $company){
            if($company['ID'] !== null){
                DB::table('ExternalContactPersonCompanies')
                ->where('ID', $company['ID'])
                ->update([
                    'IsActive' => $company['IsActive'],
                    'IsPrimaryPerson' => $company['IsPrimaryPerson'],
                    'IsPrimaryCompany' => $company['IsPrimaryCompany']
                ]);
            }
        }

        foreach ($this->compassociations as $company){
            if($company['ID'] == null){
                DB::table('ExternalContactPersonCompanies')->insert([
                    'IsActive' => $company['IsActive'],
                    'IsPrimaryPerson' => $company['IsPrimaryPerson'],
                    'IsPrimaryCompany' => $company['IsPrimaryCompany'],
                    'ExternalContactPersonId' => $company['ExternalContactPersonId'],
                    'ExternalContactCompanyId' => $company['ExternalContactCompanyId'],
                ]);
            }
        }
        
        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }

    public function addCompany()
    {
        $companyid = $this->selectedcompany;
        $company = ExternalCompanies::find($companyid);
        $compname = $company->CompanyName;
        $this->compassociations[] = ['ID' => null, 'CompanyName' => $compname, 'IsActive' => 1, 'IsPrimaryPerson' => 0, 
                                    'IsPrimaryCompany' => 0, 'ExternalContactPersonId' => $this->personid, 'ExternalContactCompanyId' => $companyid];

        //Remove company from drop down after it is selected
        $this->excludedCompanies = array_column($this->compassociations, 'ExternalContactCompanyId');

        $this->selectedcompany = null;
    }

    public function removeCompany($index)
    {
        $this->companiestodelete[] = $this->compassociations[$index];
        unset($this->compassociations[$index]);

        //Remove company from drop down after it is selected
        $this->excludedCompanies = array_column($this->compassociations, 'ExternalContactCompanyId');
    }

    public function toggleActive($index)
    {
        $newstate = $this->compassociations[$index]['IsActive'] == 1 ? 0 : 1;
        $this->compassociations[$index]['IsActive'] = $newstate;
    }

    public function toggleMainContact($index)
    {
        $newstate = $this->compassociations[$index]['IsPrimaryPerson'] == 1 ? 0 : 1;
        $this->compassociations[$index]['IsPrimaryPerson'] = $newstate;
    }

    public function togglePrimaryComp($index)
    {
        $newstate = $this->compassociations[$index]['IsPrimaryCompany'] == 1 ? 0 : 1;
        $this->compassociations[$index]['IsPrimaryCompany'] = $newstate;
    }
}
