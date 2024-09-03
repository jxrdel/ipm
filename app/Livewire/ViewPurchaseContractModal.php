<?php

namespace App\Livewire;

use App\Models\Notifications;
use App\Models\PurchaseContracts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewPurchaseContractModal extends Component
{
    public $name;
    public $purchaseditem;
    public $filenumber;
    public $filename;
    public $details;
    public $onlinelocation;
    public $manager;
    public $internalcontacts;
    public $externalcontacts;
    public $notifications;
    public $notificationcount;
    public $cost;
    public $isperpetual;
    public $startdate;
    public $enddate;
    public $extcontact;

    public function render()
    {
        return view('livewire.view-purchase-contract-modal');
    }

    #[On('show-viewpc-modal')]
    public function displayModal($id)
    {
        // $contract = PurchaseContracts::find($id);
        $contract = PurchaseContracts::where('PurchaseContracts.ID', $id)
        ->join('InternalContacts', 'PurchaseContracts.InternalContactId', '=', 'InternalContacts.ID')
        ->join('ExternalPurchases', 'PurchaseContracts.ExternalPurchaseId', '=', 'ExternalPurchases.ID')
        ->select('PurchaseContracts.*', 'ExternalPurchases.Name as PurchaseName', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName')
        ->first();

        $this->name = $contract->Name;
        $this->purchaseditem = $contract->PurchaseName;
        $this->filenumber = $contract->FileNumber;
        $this->filename = $contract->FileName;
        $this->details = $contract->Details;
        $this->onlinelocation = $contract->OnlineLocation;
        $this->manager = $contract->FirstName . ' ' . $contract->LastName;
        $this->cost = $contract->Cost;
        $this->isperpetual = $contract->IsPerpetual;
        $this->startdate = Carbon::parse($contract->StartDate)->format('d/m/Y');
        $this->enddate = Carbon::parse($contract->EndDate)->format('d/m/Y');
        
        
        $internalcontacts = DB::table('InternalContactPurchaseContracts')
            ->where('PurchaseContractId', $id)
            ->join('InternalContacts', 'InternalContactPurchaseContracts.InternalContactId', '=', 'InternalContacts.ID')
            ->select('InternalContactPurchaseContracts.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
            ->get();

        $this->internalcontacts = $internalcontacts;

        
        $externalcontacts = DB::table('ExternalContactPurchaseContracts')
            ->where('PurchaseContractId', $id)
            ->join('ExternalContactPersons', 'ExternalContactPurchaseContracts.ExternalContactPersonId', '=', 'ExternalContactPersons.ID')
            ->select('ExternalContactPurchaseContracts.*', 'ExternalContactPersons.FirstName', 'ExternalContactPersons.LastName')
            ->get();

        $this->externalcontacts = $externalcontacts;

        
        $notifications = Notifications::where('ItemId', $id)
            ->where('TypeId', 1)
            ->get();

        $this->notifications = $notifications;
        
        $this->notificationcount = Notifications::where('ItemId', $id)
            ->where('TypeId', 1)
            ->count();

        $this->dispatch('display-viewpc-modal');
    }
}
