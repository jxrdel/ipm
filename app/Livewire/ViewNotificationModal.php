<?php

namespace App\Livewire;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewNotificationModal extends Component
{
    public $notificationid;
    public $itemname;
    public $typeid;
    public $icon;
    public $label;
    public $displaydate;
    public $statusdate;
    public $statusid;
    public $status;
    public $statuscreatorid;
    public $statuscreator;
    public $itemid;
    public $controller;
    public $action;

    public $usernotifications;
    public $usernotificationcount;


    public function render()
    {
        return view('livewire.view-notification-modal');
    }

    #[On('show-noti-modal')]
    public function displayModal($id)
    {
        $notification = Notifications::find($id);

        $notification = Notifications::where('NotificationItems.ID', $id)
            ->join('Users', 'NotificationItems.StatusCreatorId', '=', 'Users.ID')
            ->select('NotificationItems.*', 'Users.Name as CreatorName')
            ->first();

        $this->notificationid = $notification->ID;
        $this->typeid = $notification->TypeId;
        $this->label = $notification->Label;
        $this->icon = $notification->Icon;
        $this->displaydate = Carbon::parse($notification->DisplayDate)->format('d/m/Y');
        $this->statusdate = Carbon::parse($notification->StatusCreationDate)->format('d/m/Y');
        $this->statusid = $notification->StatusId;
        // $this->status = $notification->ID;
        $this->statuscreatorid = $notification->StatusCreatorId;
        $this->statuscreator = $notification->CreatorName;
        $this->itemid = $notification->ItemId;
        $this->itemname = $notification->ItemName;
        $this->controller = $notification->ItemController;
        $this->action = $notification->ItemAction;

        $usernotifications = DB::table('InternalContactNotificationItems')
            ->where('NotificationItemId', $id)
            ->join('InternalContacts', 'InternalContactNotificationItems.InternalContactId', '=', 'InternalContacts.ID')
            ->select('InternalContactNotificationItems.*', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName')
            ->get();

        $this->usernotifications = $usernotifications;

        $usernotificationcount = DB::table('InternalContactNotificationItems')
            ->where('NotificationItemId', $id)
            ->join('InternalContacts', 'InternalContactNotificationItems.InternalContactId', '=', 'InternalContacts.ID')
            ->count();

        $this->usernotificationcount = $usernotificationcount;

        $this->dispatch('display-noti-modal');
    }
}
