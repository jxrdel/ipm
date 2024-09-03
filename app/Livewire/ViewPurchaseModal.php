<?php

namespace App\Livewire;

use App\Models\Purchases;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewPurchaseModal extends Component
{
    public $name;
    public $compname;
    public $details;
    public $type;
    public $isactive;
    public $associatedcontracts;
    public $associationcount;

    public function render()
    {
        return view('livewire.view-purchase-modal');
    }
    #[On('show-viewpurchase-modal')]
    public function displayModal($id)
    {
        $purchase = Purchases::where('ExternalPurchases.ID', $id)
            ->join('ExternalContactCompanies', 'ExternalPurchases.ExternalContactCompanyId', '=', 'ExternalContactCompanies.ID')
            ->join('ExternalPurchaseTypes', 'ExternalPurchases.ExternalPurchaseTypeId', '=', 'ExternalPurchaseTypes.ID')
            ->select('ExternalPurchases.*', 'ExternalContactCompanies.CompanyName as CompanyName', 'ExternalPurchaseTypes.Name as PTypeName')
            ->first();

        $this->name = $purchase->Name;
        $this->compname = $purchase->CompanyName;
        $this->details = $purchase->Details;
        $this->type = $purchase->PTypeName;
        $this->isactive = $purchase->IsActive;

        $contractassociations = DB::table('PurchaseContracts')
            ->where('ExternalPurchaseId', $id)
            ->join('ExternalPurchases', 'PurchaseContracts.ExternalPurchaseId', '=', 'ExternalPurchases.ID')
            ->select('PurchaseContracts.*')
            ->get();

        $this->associatedcontracts = $contractassociations;

        $associationcount = DB::table('PurchaseContracts')
            ->where('ExternalPurchaseId', $id)
            ->join('ExternalPurchases', 'PurchaseContracts.ExternalPurchaseId', '=', 'ExternalPurchases.ID')
            ->count();

        $this->associationcount = $associationcount;

        $this->dispatch('display-viewpurchase-modal');
    }
}
