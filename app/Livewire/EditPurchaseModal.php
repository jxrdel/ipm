<?php

namespace App\Livewire;

use App\Models\ExternalCompanies;
use App\Models\Purchases;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditPurchaseModal extends Component
{
    public $purchaseid;
    public $name;
    public $company;
    public $companies;
    public $details;
    public $type;
    public $purchasetypes;
    public $isactive;

    public function mount()
    {
        $this->companies = ExternalCompanies::all();
        $this->purchasetypes = DB::table('ExternalPurchaseTypes')
            ->get();
    }

    public function render()
    {
        return view('livewire.edit-purchase-modal');
    }

    #[On('show-editpurchase-modal')]
    public function displayModal($id)
    {
        $purchase = Purchases::find($id);
        $this->purchaseid = $purchase->ID;
        $this->name = $purchase->Name;
        $this->company = $purchase->ExternalContactCompanyId;
        $this->details = $purchase->Details;
        $this->type = $purchase->ExternalPurchaseTypeId;
        $IsActive = $purchase->IsActive == 1 ? true : false;
        $this->isactive = $IsActive;
        $this->dispatch('display-editpurchase-modal');
    }
    public function editPurchase()
    {
        $IsActive = $this->isactive == true ? 1 : 0;

        Purchases::where('ID', $this->purchaseid)->update([
            'Name' => $this->name,
            'Details' => $this->details,
            'ExternalPurchaseTypeId' => $this->type,
            'ExternalContactCompanyId' => $this->company,
            'IsActive' => $IsActive,
        ]);
        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }
}
