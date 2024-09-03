<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use App\Models\Purchases;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreatePurchaseModal extends Component
{
    public $name;
    public $company;
    public $companies;
    public $details;
    public $type;
    public $purchasetypes;
    public $isactive = true;

    public function mount()
    {
        $this->companies = ExternalCompanies::all();
        $this->purchasetypes = DB::table('ExternalPurchaseTypes')
            ->get();
    }

    public function render()
    {
        return view('livewire.create-purchase-modal');
    }

    public function createPurchase()
    {
        $IsActive = $this->isactive == true ? 1 : 0;

        Purchases::create([
            'Name' => $this->name,
            'Details' => $this->details,
            'ExternalPurchaseTypeId' => $this->type,
            'ExternalContactCompanyId' => $this->company,
            'IsActive' => $IsActive,
        ]);

        $this->name = null;
        $this->company = null;
        $this->details = null;
        $this->type = null;
        $this->isactive = true;

        $this->dispatch('close-create-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-create-success');
    }
}
