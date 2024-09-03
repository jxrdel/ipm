<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\ExternalPersons;
use App\Models\InternalContacts;
use App\Models\PurchaseContracts;
use App\Models\Purchases;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditPurchaseContractModal extends Component
{
    public $purchaseid;
    public $name;
    public $purchaseditem;
    public $filenumber;
    public $filename;
    public $details;
    public $onlinelocation;
    public $manager;
    public $selectedec;
    public $selectedic;
    public $selectedusernotification;
    public $associatedec = [];
    public $associatedic = [];
    public $excludedEC = [];
    public $excludedIC = [];
    public $ICToDelete = [];
    public $ECToDelete = [];
    public $usernotifications = [];
    public $UNToDelete = [];
    public $excludedUsers = [];
    public $cost;
    public $isperpetual = "true";
    public $startdate;
    public $enddate;

    public $purchases;
    public $managers;
    public $employees;
    public $departments;
    public $internalcontacts;
    public $empnotifications;
    public $extcontacts;

    public function mount()
    {
        $this->purchases = Purchases::all();
        $this->managers = InternalContacts::all();
        $this->employees = InternalContacts::all();
        $this->departments = Departments::all();
        $this->extcontacts = ExternalPersons::all();
    }

    public function render()
    {
        return view('livewire.edit-purchase-contract-modal');
    }

    #[On('show-editpc-modal')]
    public function displayModal($id)
    {
        $this->dispatch('clear-ic-select');
        $this->ICToDelete = [];
        $this->ECToDelete = [];
        $this->UNToDelete = [];
        $this->excludedUsers = [];
        $this->usernotifications = [];
        $this->selectedusernotification = null;
        $contract = PurchaseContracts::find($id);
        $this->purchaseid = $contract->ID;
        $this->name = $contract->Name;
        $this->details = $contract->Details;
        $this->filenumber = $contract->FileNumber;
        $this->filename = $contract->FileName;
        $this->onlinelocation = $contract->OnlineLocation;
        $this->isperpetual = $contract->IsPerpetual == 1 ? true : false;

        $this->startdate = Carbon::parse($contract->StartDate)->format('Y-m-d');
        $this->enddate = Carbon::parse($contract->EndDate)->format('Y-m-d');
        $this->cost = $contract->Cost;
        $this->purchaseditem = $contract->ExternalPurchaseId;
        $this->manager = $contract->InternalContactId;


        $internalcontacts = DB::table('InternalContactPurchaseContracts')
            ->where('PurchaseContractId', $this->purchaseid)
            ->join('InternalContacts', 'InternalContactPurchaseContracts.InternalContactId', '=', 'InternalContacts.ID')
            ->select('InternalContactPurchaseContracts.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
            ->get();

        $this->associatedic = $internalcontacts;
        $this->associatedic = json_decode(json_encode($this->associatedic), true);
        
        $this->excludedIC = array_column($this->associatedic, 'InternalContactId');
        
        //Get notified users
        $notifiedusers = DB::table('NotificationItems') //Find any notification item for this purchase
            ->where('ItemId', $this->purchaseid)
            ->where('TypeId', 1)
            ->first();
            // dd($notifiedusers);

        if($notifiedusers){
            $notifiedusers = DB::table('InternalContactNotificationItems') //Get users who receive notifications for this item
            ->where('NotificationItemId', $notifiedusers->ID)
            ->join('InternalContacts', 'InternalContactNotificationItems.InternalContactId', '=', 'InternalContacts.ID')
            ->select('InternalContactNotificationItems.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
            ->get();

            $this->usernotifications = $notifiedusers;
            $this->usernotifications = json_decode(json_encode($this->usernotifications), true);
            
            $this->excludedUsers = array_column($this->usernotifications, 'InternalContactId');
        }


        $externalcontacts = DB::table('ExternalContactPurchaseContracts')
            ->where('PurchaseContractId', $this->purchaseid)
            ->join('ExternalContactPersons', 'ExternalContactPurchaseContracts.ExternalContactPersonId', '=', 'ExternalContactPersons.ID')
            ->select('ExternalContactPurchaseContracts.*', 'ExternalContactPersons.FirstName', 'ExternalContactPersons.LastName')
            ->get();

        $this->associatedec = $externalcontacts;
        $this->associatedec = json_decode(json_encode($this->associatedec), true);

        if ($this->isperpetual == true) {
            $this->dispatch('hide-items');
        }

        $this->dispatch('display-editpc-modal');
    }
    
    public function editPC(){
        // dd($this->UNToDelete);

        PurchaseContracts::where('ID', $this->purchaseid)->update([
            'Name' => $this->name,
            'Details' => $this->details,
            'FileNumber' => $this->filenumber,
            'FileName' => $this->filename,
            'OnlineLocation' => $this->onlinelocation,
            'StartDate' => $this->startdate,
            'EndDate' => $this->enddate,
            'Cost' => $this->cost,
            'ExternalPurchaseId' => $this->purchaseditem,
            'InternalContactId' => $this->manager,
        ]);
        
        foreach ($this->associatedic as $contact){ // Insert associated internal contact
            if($contact['ID'] == null){
                DB::table('InternalContactPurchaseContracts')->insert([
                    'InternalContactId' => $contact['InternalContactId'],
                    'PurchaseContractId' => $contact['PurchaseContractId'],
                ]);
            }
        }

        foreach ($this->ICToDelete as $contact){
            if($contact['ID'] !== null){ //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('InternalContactPurchaseContracts')
                ->where('ID', $contact['ID'])
                ->delete();
            }
        }
        
        foreach ($this->associatedec as $contact){ // Insert associated external contact
            if($contact['ID'] == null){
                DB::table('ExternalContactPurchaseContracts')->insert([
                    'IsPrimary' => $contact['IsPrimary'],
                    'PurchaseContractId' => $contact['PurchaseContractId'],
                    'ExternalContactPersonId' => $contact['ExternalContactPersonId'],
                ]);
            }
        }

        foreach ($this->ECToDelete as $contact){
            if($contact['ID'] !== null){ //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('ExternalContactPurchaseContracts')
                ->where('ID', $contact['ID'])
                ->delete();
            }
        }

        if($this->UNToDelete){
            
        $notifications = DB::table('NotificationItems') //Find any notification item for this purchase
        ->where('ItemId', $this->purchaseid)
        ->where('TypeId', 1)
        ->get();
        // dd($notifications);

        $allUserNotifications = [];
        if($notifications){ // If the purchase contract has a notification
            foreach($notifications as $notification){

                $usernotifications = DB::table('InternalContactNotificationItems') //Get users who receive notifications for this item
                ->where('NotificationItemId', $notification->ID)
                ->join('InternalContacts', 'InternalContactNotificationItems.InternalContactId', '=', 'InternalContacts.ID')
                ->select('InternalContactNotificationItems.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
                ->get();

                foreach($usernotifications as $usernotification){
                    $allUserNotifications [] = ['ID' => $usernotification->ID, 'InternalContactId' => $usernotification->InternalContactId, 'NotificationItemId' => $usernotification->NotificationItemId];
                }
            }

        }
        // dd($this->UNToDelete);
        
        foreach ($this->UNToDelete as $user){ // Delete user notification

            foreach($allUserNotifications as $notification){
                if($notification['InternalContactId'] == $user['InternalContactId']){ //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                    DB::table('InternalContactNotificationItems')
                    ->where('ID', $notification['ID'])
                    ->delete();
                }
            }
            
        }

        }
        
        $this->dispatch('close-edit-modal');
        $this->dispatch('refresh-table');
        $this->dispatch('show-edit-success');
    }

    public function addInternalContact()
    {
        if ($this->selectedic == ''){
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedic;
            $contact = InternalContacts::find($contactid);
            $this->associatedic[] = [   'ID' => null, 'InternalContactId' => $contactid, 'PurchaseContractId' => $this->purchaseid, 
                                        'FirstName' => $contact->FirstName, 'LastName' => $contact->LastName
                                    ];
    
            //Remove company from drop down after it is selected
            $this->excludedIC = array_column($this->associatedic, 'InternalContactId');
    
            // session(['selectedCompanies' => $this->selectedCompanies]);
            $this->selectedic = null;
        }
    }

    public function removeInternalContact($index)
    {
        $this->ICToDelete[] = $this->associatedic[$index];
        unset($this->associatedic[$index]);

        //Remove company from drop down after it is selected
        $this->excludedIC = array_column($this->associatedic, 'InternalContactId');
    }


    public function addNotifiedUser()
    {
        // dd($this->usernotifications);
        if ($this->selectedusernotification == ''){
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedusernotification;
            $contact = InternalContacts::find($contactid);
            $this->usernotifications[] = [   'ID' => null, 'InternalContactId' => $contactid, 'NotificationItemId' => null, 
                                        'FirstName' => $contact->FirstName, 'LastName' => $contact->LastName
                                    ];
    
            //Remove company from drop down after it is selected
            $this->excludedUsers = array_column($this->usernotifications, 'InternalContactId');
    
            // session(['selectedCompanies' => $this->selectedCompanies]);
            $this->selectedusernotification = null;
        }
    }

    public function removeNotifiedUser($index)
    {
        // dd($this->usernotifications[$index]);
        $this->UNToDelete[] = $this->usernotifications[$index];
        unset($this->usernotifications[$index]);

        
        $this->excludedUsers = array_column($this->usernotifications, 'InternalContactId');
    }

    public function addExternalContact()
    {
        // dd($this->associatedec);
        if ($this->selectedec == ''){
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedec;
            $contact = ExternalPersons::find($contactid);
            $contactname = $contact->FirstName . ' ' . $contact->LastName;
            $this->associatedec[] = [   'ID' => null, 'IsPrimary' => 1, 'PurchaseContractId' => $this->purchaseid, 'ExternalContactPersonId' => $contactid, 
                                        'FirstName' => $contact->FirstName, 'LastName' => $contact->LastName
                                    ];
    
            //Remove company from drop down after it is selected
            $this->excludedEC = array_column($this->associatedec, 'ExternalContactPersonId');
    
            // session(['selectedCompanies' => $this->selectedCompanies]);
            $this->selectedec = null;
        }
    }

    public function removeExternalContact($index)
    {
        $this->ECToDelete[] = $this->associatedec[$index];
        unset($this->associatedec[$index]);

        //Remove company from drop down after it is selected
        $this->excludedEC = array_column($this->associatedec, 'ExternalContactPersonId');
    }

    public function toggleMainContact($index)
    {
        // dd($this->associatedec[$index]['IsPrimary']);
        $newstate = $this->associatedec[$index]['IsPrimary'] == 1 ? 0 : 1;
        $this->associatedec[$index]['IsPrimary'] = $newstate;
    }
}
