<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\ExternalPersons;
use App\Models\InternalContacts;
use App\Models\Notifications;
use App\Models\PurchaseContracts;
use App\Models\Purchases;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPurchaseContract extends Component
{
    use WithFileUploads;

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
    public $notifications;
    public $associatedec = [];
    public $associatedic = [];
    public $excludedEC = [];
    public $excludedIC = [];
    public $ICToDelete = [];
    public $editedIC = [];
    public $isEditedIC;
    public $ECToDelete = [];
    public $NotificationsToDelete = [];
    public $usernotifications = [];
    public $UNToDelete = [];
    public $editedUN = [];
    public $isEditedUN;
    public $excludedUsers = [];
    public $cost;
    public $isperpetual = "true";
    public $startdate;
    public $enddate;
    public $notidate;
    public $notification_message;
    public $is_custom_notification = false;
    public $fileuploads;
    public $uploadInput;

    public $contract;
    public $purchases;
    public $managers;
    public $employees;
    public $departments;
    public $internalcontacts;
    public $empnotifications;
    public $extcontacts;

    #[Title('Edit Purchase Contract')]

    public function render()
    {
        $this->fileuploads = $this->contract->uploads()->get(); // Make sure this updates
        // dd($this->fileuploads);
        return view('livewire.edit-purchase-contract');
    }

    public function mount($id)
    {
        $this->purchases = Purchases::all();
        $this->managers = InternalContacts::all();
        $this->employees = InternalContacts::all();
        $this->departments = Departments::all();
        $this->extcontacts = ExternalPersons::all();
        $this->ICToDelete = [];
        $this->ECToDelete = [];
        $this->UNToDelete = [];
        $this->excludedUsers = [];
        $this->usernotifications = [];
        $this->selectedusernotification = null;
        $this->contract = PurchaseContracts::find($id);
        $this->purchaseid = $this->contract->ID;
        $this->name = $this->contract->Name;
        $this->details = $this->contract->Details;
        $this->filenumber = $this->contract->FileNumber;
        $this->filename = $this->contract->FileName;
        $this->onlinelocation = $this->contract->OnlineLocation;
        $this->isperpetual = $this->contract->IsPerpetual == 1 ? true : false;

        $this->startdate = Carbon::parse($this->contract->StartDate)->format('Y-m-d');
        $this->enddate = Carbon::parse($this->contract->EndDate)->format('Y-m-d');
        $this->cost = $this->contract->Cost;
        $this->purchaseditem = $this->contract->ExternalPurchaseId;
        $this->manager = $this->contract->InternalContactId;


        $internalcontacts = DB::table('InternalContactPurchaseContracts')
            ->where('PurchaseContractId', $this->purchaseid)
            ->join('InternalContacts', 'InternalContactPurchaseContracts.InternalContactId', '=', 'InternalContacts.ID')
            ->select('InternalContactPurchaseContracts.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
            ->get()
            ->pluck('InternalContactId');

        $this->associatedic = $internalcontacts;
        // $this->associatedic = json_decode(json_encode($this->associatedic), true);

        //Get notified users
        $notifiedusers = DB::table('NotificationItems') //Find any notification item for this purchase
            ->where('ItemId', $this->purchaseid)
            ->where('TypeId', 1)
            ->first();
        // dd($notifiedusers);

        if ($notifiedusers) {
            $notifiedusers = DB::table('InternalContactNotificationItems') //Get users who receive notifications for this item
                ->where('NotificationItemId', $notifiedusers->ID)
                ->join('InternalContacts', 'InternalContactNotificationItems.InternalContactId', '=', 'InternalContacts.ID')
                ->select('InternalContactNotificationItems.*', 'InternalContacts.FirstName', 'InternalContacts.LastName')
                ->get()
                ->pluck('InternalContactId');

            $this->usernotifications = $notifiedusers;
        }

        $this->notifications = $this->contract->notifications;


        $this->notifications = json_decode(json_encode($this->notifications), true);

        $externalcontacts = DB::table('ExternalContactPurchaseContracts')
            ->where('PurchaseContractId', $this->purchaseid)
            ->join('ExternalContactPersons', 'ExternalContactPurchaseContracts.ExternalContactPersonId', '=', 'ExternalContactPersons.ID')
            ->select('ExternalContactPurchaseContracts.*', 'ExternalContactPersons.FirstName', 'ExternalContactPersons.LastName')
            ->get();

        $this->associatedec = $externalcontacts;
        $this->associatedec = json_decode(json_encode($this->associatedec), true);
    }

    public function editPC()
    {

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

        if ($this->isEditedIC) {
            $this->contract->internalcontacts()->sync($this->editedIC);
        }

        foreach ($this->associatedec as $contact) { // Insert associated external contact
            if ($contact['ID'] == null) {
                DB::table('ExternalContactPurchaseContracts')->insert([
                    'IsPrimary' => $contact['IsPrimary'],
                    'PurchaseContractId' => $contact['PurchaseContractId'],
                    'ExternalContactPersonId' => $contact['ExternalContactPersonId'],
                ]);
            }
        }

        foreach ($this->ECToDelete as $contact) {
            if ($contact['ID'] !== null) { //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('ExternalContactPurchaseContracts')
                    ->where('ID', $contact['ID'])
                    ->delete();
            }
        }

        foreach ($this->NotificationsToDelete as $notification) {
            if ($notification['ID'] !== null) { //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('NotificationItems')
                    ->where('ID', $notification['ID'])
                    ->delete();
            }
        }

        foreach ($this->notifications as $notification) { // Save new notifications
            $newNotifications = [];
            if ($notification['ID'] == null) {
                $label = '';
                $difference = Carbon::parse($notification['DisplayDate'])->diff(Carbon::parse($this->enddate));

                if ($difference->y > 0) {
                    $label = 'Please be advised that the contract for ' . $this->name . ' ends in ' . $difference->y . ' year(s) ,' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                } else if ($difference->y < 1 && $difference->m > 0) {
                    $label = 'Please be advised that the contract for ' . $this->name . ' ends in ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                } else if ($difference->y < 1 && $difference->m < 1 && $difference->d > 0) {
                    $label = 'Please be advised that the contract for ' . $this->name . ' ends in ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                }
                $newNotifications[] = [
                    'label' => $label,
                    'itemname' => $this->name,
                    'itemcontroller' => 'PurchaseContract',
                    'itemaction' => 'Details',
                    'itemid' => $this->purchaseid,
                    'displaydate' => $notification['DisplayDate'],
                    'typeid' => 1,
                    'statusid' => 1,
                    'statuscreatorid' => Auth::user()->ID,
                    'statuscreationdate' => Carbon::now('AST')->format('Y-m-d H:i:s')
                ];
            }


            foreach ($newNotifications as $notification) { // Create notification
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


                if ($this->isEditedUN) {
                    $newnotification->internalcontacts()->sync($this->editedUN);
                } else {
                    $newnotification->internalcontacts()->sync($this->contract->notifications->first()->internalcontacts->pluck('ID'));
                }
            }
        }

        if ($this->isEditedUN) {
            foreach ($this->contract->notifications as $notification) {
                $notification->internalcontacts()->sync($this->editedUN);
            }
        }

        return redirect()->route('purchasecontracts')->with('success', 'Purchase Contract updated successfully');
    }

    public function addInternalContact()
    {
        if ($this->selectedic == '') {
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedic;
            $contact = InternalContacts::find($contactid);
            $this->associatedic[] = [
                'ID' => null,
                'InternalContactId' => $contactid,
                'PurchaseContractId' => $this->purchaseid,
                'FirstName' => $contact->FirstName,
                'LastName' => $contact->LastName
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
        if ($this->selectedusernotification == '') {
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedusernotification;
            $contact = InternalContacts::find($contactid);
            $this->usernotifications[] = [
                'ID' => null,
                'InternalContactId' => $contactid,
                'NotificationItemId' => null,
                'FirstName' => $contact->FirstName,
                'LastName' => $contact->LastName
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
        if ($this->selectedec == '') {
            $message = "Please select a contact";
            $this->dispatch('show-alert', message: $message);
        } else {
            $contactid = $this->selectedec;
            $contact = ExternalPersons::find($contactid);
            $contactname = $contact->FirstName . ' ' . $contact->LastName;
            $this->associatedec[] = [
                'ID' => null,
                'IsPrimary' => 1,
                'PurchaseContractId' => $this->purchaseid,
                'ExternalContactPersonId' => $contactid,
                'FirstName' => $contact->FirstName,
                'LastName' => $contact->LastName
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

    public function addNotification()
    {
        $this->resetValidation();
        if ($this->notidate == null || trim($this->notidate) == '') {
            // $this->dispatch('show-alert', message: "Please select a date");
            $this->addError('notidate', 'Please select a date');
            return;
        } else if (in_array(Carbon::parse($this->notidate)->format('Y-m-d H:i:s.v'), array_column($this->notifications, 'DisplayDate'))) {
            $this->addError('notidate', 'Notification already added');
            return;
        } else if (Carbon::parse($this->notidate) < Carbon::now()) {
            $this->addError('notidate', 'Notification date must be after today');
            return;
        } else if ($this->is_custom_notification && ($this->notification_message == null || trim($this->notification_message) == '')) {
            $this->addError('notification_message', 'Please enter a message');
            return;
        }

        $this->notifications[] = ['ID' => null, 'DisplayDate' => $this->notidate, 'IsCustomNotification' => $this->is_custom_notification, 'NotificationMessage' => $this->notification_message];

        $this->notidate = null;
        $this->notification_message = null;
        $this->is_custom_notification = false;

        $this->dispatch('close-notification-modal');
        $this->dispatch('show-message', message: 'Notification added successfully');
    }

    public function removeNotification($index)
    {
        $this->NotificationsToDelete[] = $this->notifications[$index];
        unset($this->notifications[$index]);
    }

    public function uploadFiles()
    {
        if (!is_null($this->uploadInput)) {
            // dd($this->uploadInput);
            $path = $this->uploadInput->store('purchase_contracts', 'public');
            $this->contract->uploads()->create([
                'FilePath' => $path,
                'UploadedBy' => Auth::user()->Name,
                'UploadedDate' => Carbon::now('AST')->format('Y-m-d H:i:s'),
            ]);

            $this->uploadInput = null;
            $this->dispatch('show-message', message: 'File uploaded successfully');
        } else {
            $this->dispatch('show-alert', message: 'Please select a file to upload');
        }
    }

    public function deleteUpload($id)
    {
        $upload = $this->contract->uploads->where('ID', $id)->first();
        $upload->delete();
        Storage::delete('public/' . $upload->FilePath);
        $this->dispatch('show-message', message: 'File deleted successfully');
    }
}
