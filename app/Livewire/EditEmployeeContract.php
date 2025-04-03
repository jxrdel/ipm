<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\EmployeeContracts;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditEmployeeContract extends Component
{
    use WithFileUploads;

    #[Title('Edit Employee Contract')]

    public $contractid;
    public $employee;
    public $role;
    public $filenumber;
    public $filename;
    public $details;
    public $onlinelocation;
    public $manager;
    public $department;
    public $startdate;
    public $enddate;
    public $isperpetual;
    public $notifications;
    public $contract;
    public $usernotifications;
    public $associateddepartments;
    public $notidate;
    public $fileuploads;
    public $uploadInput;

    public $editedUN = [];
    public $isEditedUN;

    public $editedDepts = [];
    public $isEditedDepts;

    public $NotificationsToDelete = [];

    public $roles;
    public $managers;
    public $employees;
    public $departments;
    public $loggedinuser;

    public function mount($id)
    {
        $this->roles = MOHRoles::all();
        $this->managers = InternalContacts::all();
        $this->employees = InternalContacts::all();
        $this->departments = Departments::all();
        $this->loggedinuser = Auth::user()->internalcontact->ID;
        $this->contract = EmployeeContracts::find($id);
        // $this->contract = EmployeeContracts::where('EmployeeContracts.ID', $id)
        //     ->join('InternalContacts', 'EmployeeContracts.EmployeeContactId', '=', 'InternalContacts.ID')
        //     ->join('MOHRoles', 'EmployeeContracts.MOHRoleId', '=', 'MOHRoles.ID')
        //     ->join('BusinessGroups', 'EmployeeContracts.BusinessGroupId', '=', 'BusinessGroups.ID')
        //     ->select('EmployeeContracts.*', 'MOHRoles.Name as RoleName', 'InternalContacts.FirstName as FirstName', 'InternalContacts.LastName as LastName', 'BusinessGroups.Name as Department')
        //     ->first();

        // dd($this->contract);
        $this->contractid = $this->contract->ID;
        $this->employee = $this->contract->EmployeeContactId;
        $this->role = $this->contract->MOHRoleId;
        $this->filenumber = $this->contract->FileNumber;
        $this->filename = $this->contract->FileName;
        $this->details = $this->contract->Details;
        $this->onlinelocation = $this->contract->OnlineLocation;
        $this->manager = $this->contract->ManagerContactId;
        $this->department = $this->contract->BusinessGroupId;
        $this->isperpetual = $this->contract->IsPerpetual == 1 ? true : false;
        // dd($this->isperpetual);
        $this->startdate = Carbon::parse($this->contract->StartDate)->format('Y-m-d');
        $this->enddate = Carbon::parse($this->contract->EndDate)->format('Y-m-d');


        $this->notifications = $this->contract->notifications;

        if ($this->notifications) {
            $this->usernotifications = $this->notifications->pluck('internalcontacts')->flatten()->pluck('ID')->flatten();
        }

        $this->notifications = json_decode(json_encode($this->notifications), true);

        $this->associateddepartments = $this->contract->departments->pluck('ID')->flatten();
        // dd($this->associateddepartments);
    }

    public function render()
    {
        $this->fileuploads = $this->contract->uploads()->get(); // Make sure this updates
        // dd($this->fileuploads);
        return view('livewire.edit-employee-contract');
    }

    public function editEC()
    {
        // dd($this->editedUN);

        EmployeeContracts::where('ID', $this->contractid)->update([
            'Details' => $this->details,
            'FileNumber' => $this->filenumber,
            'FileName' => $this->filename,
            'OnlineLocation' => $this->onlinelocation,
            'StartDate' => $this->startdate,
            'EndDate' => $this->enddate,
            'EmployeeContactId' => $this->employee,
            'MOHRoleId' => $this->role,
            'BusinessGroupId' => $this->department,
            'ManagerContactId' => $this->manager
        ]);

        foreach ($this->NotificationsToDelete as $notification) {
            if ($notification['ID'] !== null) { //Items in the array with null ID were not in the database to begin with so they do not need to be deleted
                DB::table('NotificationItems')
                    ->where('ID', $notification['ID'])
                    ->delete();
            }
        }
        foreach ($this->notifications as $notification) { // Save new notifications
            $newNotifications = [];
            $employee = InternalContacts::find($this->employee);
            $employeeName = $employee->FirstName . ' ' . $employee->LastName;

            if ($notification['ID'] == null) {
                $label = '';
                $difference = Carbon::parse($notification['DisplayDate'])->diff(Carbon::parse($this->enddate));

                if ($difference->y > 0) {
                    $label = 'Please be advised that the contract for ' . $employeeName . ' ends in ' . $difference->y . ' year(s) ,' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                } else if ($difference->y < 1 && $difference->m > 0) {
                    $label = 'Please be advised that the contract for ' . $employeeName . ' ends in ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                } else if ($difference->y < 1 && $difference->m < 1 && $difference->d > 0) {
                    $label = 'Please be advised that the contract for ' . $employeeName . ' ends in ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                }
                $newNotifications[] = [
                    'label' => $label,
                    'itemname' => $employeeName,
                    'itemcontroller' => 'EmployeeContract',
                    'itemaction' => 'Details',
                    'itemid' => $this->contractid,
                    'displaydate' => $notification['DisplayDate'],
                    'typeid' => 2,
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
                    $newnotification->internalcontacts()->sync($this->editedDepts);
                } else {
                    $newnotification->internalcontacts()->sync($this->contract->notifications->first()->internalcontacts->pluck('ID'));
                }
            }
        }

        if ($this->editedDepts) {
            $this->contract->departments()->sync($this->editedDepts);
        }

        if ($this->isEditedUN) {
            foreach ($this->contract->notifications as $notification) {
                $notification->internalcontacts()->sync($this->editedUN);
            }
        }

        return redirect()->route('employeecontracts')->with('success', 'Employee Contract updated successfully');
    }

    public function addNotification()
    {

        if ($this->notidate == null) {
            $this->dispatch('show-alert', message: "Please select a date");
            return;
        } else if (in_array(Carbon::parse($this->notidate)->format('Y-m-d H:i:s.v'), array_column($this->notifications, 'DisplayDate'))) {
            $this->dispatch('show-alert', message: "Notification already added");
            return;
        } else if (Carbon::parse($this->notidate) < Carbon::now()) {
            $this->dispatch('show-alert', message: "Notification date must be after today's date");
            return;
        }

        $this->notifications[] = ['ID' => null, 'DisplayDate' => $this->notidate];
        $this->notidate = null;
    }

    public function uploadFiles()
    {

        if (!is_null($this->uploadInput)) {
            // dd($this->uploadInput);
            $path = $this->uploadInput->store('employee_contracts', 'public');
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

    public function removeNotification($index)
    {
        $this->NotificationsToDelete[] = $this->notifications[$index];
        unset($this->notifications[$index]);
    }
}
