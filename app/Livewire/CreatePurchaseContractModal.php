<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\ExternalPersons;
use App\Models\InternalContacts;
use App\Models\Notifications;
use App\Models\PurchaseContracts;
use App\Models\Purchases;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CreatePurchaseContractModal extends Component
{
    public $departmentaccess;
    public $name;
    public $purchaseditem;
    public $filenumber;
    public $filename;
    public $details;
    public $onlinelocation;
    public $manager;
    public $selectedec;
    public $selectedic = [];
    public $associatedec = [];
    public $excludedContacts = [];
    public $cost;
    public $isperpetual = "true";
    public $startdate;
    public $enddate;
    public $monthsbefore = 1;

    public $purchases;
    public $managers;
    public $employees;
    public $departments;
    public $internalcontacts;
    public $loggedinuser;
    public $empnotifications;
    public $extcontacts;

    public function mount()
    {
        $this->purchases = Purchases::all();
        $this->managers = InternalContacts::all();
        $this->employees = InternalContacts::all();
        $this->departments = Departments::all();
        $this->extcontacts = ExternalPersons::all();
        $this->loggedinuser = Auth::user()->internalcontact->ID;

    }

    public function render()
    {
        return view('livewire.create-purchase-contract-modal');
    }

    #[On('set-internalcontacts')]
    public function setIC($values)
    {
        $this->internalcontacts = $values;
    }

    #[On('reset-enddate')]
    public function resetEndDate()
    {
        $this->enddate = null;
    }

    #[On('set-notifications')]
    public function setNotifications($values)
    {
        $this->empnotifications = $values;
    }


    public function addEContact()
    {
        if ($this->selectedec == ''){
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedec;
            $contact = ExternalPersons::find($contactid);
            $contactname = $contact->FirstName . ' ' . $contact->LastName;
            $this->associatedec[] = ['contactid' => $contactid, 'contactname' => $contactname, 'ismaincontact' => 0];
    
            //Remove company from drop down after it is selected
            $this->excludedContacts = array_column($this->associatedec, 'contactid');
    
            // session(['selectedCompanies' => $this->selectedCompanies]);
            $this->selectedec = null;
        }
    }

    public function removeContact($index)
    {
        unset($this->associatedec[$index]);

        //Remove company from drop down after it is selected
        $this->excludedContacts = array_column($this->associatedec, 'contactid');
    }

    public function isValidated(){
        if (empty($this->internalcontacts)){ //Ensures at least 1 employee gets notifications
            $this->dispatch('show-alert', message: "Please select at least one associated internal contact");
            return false;
        }
        
        if ($this->isperpetual !== 'true') { // Checks if end date is the selected options
            if (empty($this->empnotifications)){ //Ensures at least 1 employee gets notifications
                $this->dispatch('show-alert', message: "Please select at least one employee to receive notifications");
                return false;
            } else if ($this->enddate == null){ //Check for null end date
                $this->dispatch('show-alert', message: "Please select an end date");
                return false;
            } else if ($this->monthsbefore == null || $this->monthsbefore < 1){ //Check for null months before
                $this->dispatch('show-alert', message: "Please enter how many months prior to expiration you want to see notifications");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    public function createPC()
    {
        // dd($this->empnotifications);
        if ($this->isValidated()){
            $isPerPetual = $this->isperpetual == 'true' ? 1 : 0;
            if ($isPerPetual == 1) {
                $this->enddate = null;
            }
            
            $newitem = PurchaseContracts::create([
                'Name' => $this->name,
                'Details' => $this->details,
                'FileNumber' => $this->filenumber,
                'FileName' => $this->filename,
                'OnlineLocation' => $this->onlinelocation,
                'IsPerpetual' => $isPerPetual,
                'StartDate' => $this->startdate,
                'EndDate' => $this->enddate,
                'Cost' => $this->cost,
                'ExternalPurchaseId' => $this->purchaseditem,
                'InternalContactId' => $this->manager,
            ]);
    
            if ($this->departmentaccess !== ''){
                DB::table('PurchaseContractBusinessGroups')->insert([
                    'PurchaseContractId' => $newitem->ID,
                    'BusinessGroupId' => $this->departmentaccess,
                ]);
            }
            if (!empty($this->internalcontacts)) {
                foreach ($this->internalcontacts as $internalcontact) {
                    DB::table('InternalContactPurchaseContracts')->insert([
                        'InternalContactId' => $internalcontact['value'],
                        'PurchaseContractId' => $newitem->ID,
                    ]);
                }
            }
    
            if (!empty($this->associatedec)) {
                foreach ($this->associatedec as $externalcontact) {
                    DB::table('ExternalContactPurchaseContracts')->insert([
                        'IsPrimary' => $externalcontact['ismaincontact'],
                        'ExternalContactPersonId' => $externalcontact['contactid'],
                        'PurchaseContractId' => $newitem->ID,
                    ]);
                }
            }

            if ($isPerPetual == 0) {
                $notifications = [];
                for ($i = $this->monthsbefore; $i >= 1; $i--){
                    $enddate = Carbon::parse($this->enddate);
                    $displaydate = $enddate;
                    $displaydate = $displaydate->subMonths($i)->format('Y-m-d H:i:s');

                    $notifications[] = [
                        'label' => 'Please be advised that the contract for ' . $newitem->Name .' ends in ' . $i . ' month(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y'),
                        'itemname' => $newitem->Name, 
                        'itemcontroller' => 'PurchaseContract', 
                        'itemaction' => 'Details', 
                        'itemid' => $newitem->ID, 
                        'displaydate' => $displaydate, 
                        'typeid' => 1,  
                        'statusid' => 1, 
                        'statuscreatorid' => Auth::user()->ID,
                        'statuscreationdate' => Carbon::now('AST')->format('Y-m-d H:i:s')
                    ];
                    
                }
                //Make notifications for the final 3 weeks before the end date
                for ($i = 3; $i >= 1; $i--){
                    $enddate = Carbon::parse($this->enddate);
                    $displaydate = $enddate;
                    $displaydate = $displaydate->subWeeks($i)->format('Y-m-d H:i:s');

                    $notifications[] = [
                        'label' => 'Please be advised that the contract for ' . $newitem->Name .' ends in ' . $i . ' week(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y'),
                        'itemname' => $newitem->Name, 
                        'itemcontroller' => 'PurchaseContract', 
                        'itemaction' => 'Details', 
                        'itemid' => $newitem->ID, 
                        'displaydate' => $displaydate, 
                        'typeid' => 1,  
                        'statusid' => 1, 
                        'statuscreatorid' => Auth::user()->ID,
                        'statuscreationdate' => Carbon::now('AST')->format('Y-m-d H:i:s')
                    ];
                }
                    
                foreach ($notifications as $notification) { // Create notification
                    $newnotification = Notifications::create([
                        'Label' => $notification['label'],
                        'ItemName' => $notification['itemname'],
                        'ItemController' => $notification['itemcontroller'],
                        'ItemAction' => $notification['itemaction'],
                        'ItemId' => $notification['itemid'],
                        'DisplayDate' => $notification['displaydate'],
                        'TypeId' => $notification['typeid'],
                        'StatusId' => $notification['statusid'],
                        'StatusCreatorId' => $notification['statuscreatorid'],
                        'StatusCreationDate' => $notification['statuscreationdate'],
                    ]);

                    foreach ($this->empnotifications as $employee){
                        DB::table('InternalContactNotificationItems')->insert([
                            'NotificationItemId' => $newnotification->ID,
                            'InternalContactId' => $employee['value'],
                        ]);

                    }
                }
            }
    
            $this->name = null;
            $this->purchaseditem = null;
            $this->filenumber = null;
            $this->filename = null;
            $this->details = null;
            $this->onlinelocation = null;
            $this->manager = null;
            $this->selectedec = null;
            $this->selectedic = [];
            $this->associatedec = [];
            $this->internalcontacts = [];
            $this->excludedContacts = [];
            $this->cost = null;
            $this->isperpetual = "true";
            $this->startdate = null;
            $this->enddate = null;
    
            $this->dispatch('close-create-modal');
            $this->dispatch('refresh-table');
            $this->dispatch('show-create-success');
        }
        
    }

    public function toggleMainContact($index)
    {
        $newstate = $this->associatedec[$index]['ismaincontact'] == 1 ? 0 : 1;
        $this->associatedec[$index]['ismaincontact'] = $newstate;
    }
}
