<?php

namespace App\Livewire;

use App\Models\ExternalPersons;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateExternalPersonModal extends Component
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


    public function render()
    {
        return view('livewire.create-external-person-modal');
    }


    public function createExternalPerson()
    {
        $selectedCompanies = session('selectedCompanies', []);

        if (empty($selectedCompanies)) {
            $this->addError('selectedCompanies', 'At least one company must be selected.');
            return;
        }

        DB::beginTransaction();

        try {
            $IsActive = $this->isactive == true ? 1 : 0;
            // dd($IsActive);

            $newperson = ExternalPersons::create([
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

            foreach ($selectedCompanies as $company) {
                DB::table('ExternalContactPersonCompanies')->insert([
                    'IsActive' => $company['isactive'],
                    'IsPrimaryPerson' => $company['ismaincontact'],
                    'IsPrimaryCompany' => $company['isprimarycomp'],
                    'ExternalContactPersonId' => $newperson->ID,
                    'ExternalContactCompanyId' => $company['companyid'],
                ]);
            }

            DB::commit();

            $this->firstname = null;
            $this->lastname = null;
            $this->othername = null;
            $this->email = null;
            $this->address1 = null;
            $this->address2 = null;
            $this->phone1 = null;
            $this->phone2 = null;
            $this->note = null;
            $this->isactive = true;

            // session()->flush();
            $this->dispatch('reset-variables');
            $this->dispatch('close-create-modal');
            $this->dispatch('refresh-table');
            $this->dispatch('show-create-success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('selectedCompanies', 'An error occurred while saving: ' . $e->getMessage());
        }
    }
}
