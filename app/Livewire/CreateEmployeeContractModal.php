<?php

namespace App\Livewire;

use App\Models\Departments;
use App\Models\EmployeeContracts;
use App\Models\ExternalPersons;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use App\Models\Notifications;
use App\Models\Purchases;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEmployeeContractModal extends Component
{
    public $employee;
    public $role;
    public $filenumber;
    public $filename;
    public $department;
    public $details;
    public $onlinelocation;
    public $manager;
    public $isperpetual = "true";
    public $startdate;
    public $enddate;
    public $monthsbefore = 1;
    public $empnotifications;
    public $contractdepartments;

    public $roles;
    public $managers;
    public $employees;
    public $departments;
    public $loggedinuser;

    public function mount()
    {
        $this->roles = MOHRoles::orderBy('Name')->get();
        $this->managers = InternalContacts::orderBy('FirstName')->get();
        $this->employees = InternalContacts::orderBy('FirstName')->get();
        $this->departments = Departments::orderBy('Name')->get();
        $this->loggedinuser = Auth::user()->internalcontact->ID;

    }


    public function render()
    {
        return view('livewire.create-employee-contract-modal');
    }

    #[On('set-contractdepartments')]
    public function setDepartments($values)
    {
        $this->contractdepartments = $values;
    }

    #[On('set-notifications')]
    public function setNotifications($values)
    {
        $this->empnotifications = $values;
    }

    public function isValidated(){
        if (empty($this->contractdepartments)){ //Ensures at least 1 employee gets notifications
            $this->dispatch('show-alert', message: "Please select at least one associated department");
            return false;
        }
        
        if ($this->isperpetual !== 'true') { // Checks if end date is the selected options
            if ($this->enddate == null){ //Check for null end date
                $this->dispatch('show-alert', message: "Please select an end date");
                return false;
            } else if ($this->monthsbefore == null || $this->monthsbefore < 1){ //Check for null months before
                $this->dispatch('show-alert', message: "Please enter how many months prior to expiration you want to see notifications");
                return false;
            } else if (empty($this->empnotifications)){ //Ensures at least 1 employee gets notifications
                $this->dispatch('show-alert', message: "Please select at least one employee to receive notifications");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    
    public function createEC()
    {
        
        if ($this->isValidated()){
            // dd($this->contractdepartments);
            if ($this->isValidated()){
                $isPerPetual = $this->isperpetual == 'true' ? 1 : 0;
                if ($isPerPetual == 1) {
                    $this->enddate = null;
                }
                
                $newitem = EmployeeContracts::create([
                    'EmployeeContactId' => $this->employee,
                    'Details' => $this->details,
                    'FileNumber' => $this->filenumber,
                    'FileName' => $this->filename,
                    'OnlineLocation' => $this->onlinelocation,
                    'IsPerpetual' => $isPerPetual,
                    'StartDate' => $this->startdate,
                    'EndDate' => $this->enddate,
                    'MOHRoleId' => $this->role,
                    'BusinessGroupId' => $this->department,
                    'ManagerContactId' => $this->manager,
                ]);
        
                if (!empty($this->contractdepartments)) {
                    foreach ($this->contractdepartments as $contractdepartment) {
                        DB::table('EmployeeContractBusinessGroups')->insert([
                            'BusinessGroupId' => $contractdepartment['value'],
                            'EmployeeContractId' => $newitem->ID,
                        ]);
                    }
                }
    
                if ($isPerPetual == 0) {
                    $notifications = [];
                    $newEmployee = InternalContacts::find($newitem->EmployeeContactId);
                    $newEmployeeName = $newEmployee->FirstName . ' ' . $newEmployee->LastName; // Name of the employee in the new contract
    
                    for ($i = $this->monthsbefore; $i >= 1; $i--){
                        $enddate = Carbon::parse($this->enddate);
                        $displaydate = $enddate;
                        $displaydate = $displaydate->subMonths($i)->format('Y-m-d H:i:s');
    
                        $notifications[] = [
                            'label' => 'Please be advised that the contract for ' . $newEmployeeName .' ends in ' . $i . ' month(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y'),
                            'itemname' => $newEmployeeName, 
                            'itemcontroller' => 'EmployeeContract', 
                            'itemaction' => 'Details', 
                            'itemid' => $newitem->ID, 
                            'displaydate' => $displaydate, 
                            'typeid' => 2,  
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
                            'label' => 'Please be advised that the contract for ' . $newEmployeeName .' ends in ' . $i . ' week(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y'),
                            'itemname' => $newEmployeeName, 
                            'itemcontroller' => 'EmployeeContract', 
                            'itemaction' => 'Details', 
                            'itemid' => $newitem->ID, 
                            'displaydate' => $displaydate, 
                            'typeid' => 2,  
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
        
                $this->employee = null;
                $this->role = null;
                $this->filenumber = null;
                $this->filename = null;
                $this->department = null;
                $this->details = null;
                $this->onlinelocation = null;
                $this->manager = null;
                $this->isperpetual = "true";
                $this->startdate = null;
                $this->enddate = null;
                $this->empnotifications = null;
                $this->contractdepartments = null;
        
                $this->dispatch('close-create-modal');
                $this->dispatch('refresh-table');
                $this->dispatch('show-create-success');
        }

        
        }
        
    }
}
