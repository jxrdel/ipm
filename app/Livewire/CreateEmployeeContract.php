<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use App\Models\Departments;
use App\Models\EmployeeContracts;
use App\Models\ExternalPersons;
use App\Models\InternalContacts;
use App\Models\MOHRoles;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;

class CreateEmployeeContract extends Component
{
    use WithFileUploads;
    
    #[Title('Create Employee Contract')] 

    public $employee;
    public $role;
    public $filenumber;
    public $filename;
    public $department;
    public $details;
    public $onlinelocation;
    public $manager;
    public $isperpetual = "false";
    public $startdate;
    public $enddate;
    public $monthsbefore = 1;
    public $empnotifications;
    public $contractdepartments;
    public $notidate;
    public $selectednotifications = [];
    public $uploads;

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
        return view('livewire.create-employee-contract');
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

    
    public function createEC()
    {
        $validator = Validator::make([
            'uploads' => $this->uploads, // assuming $this->uploads contains the uploaded files
            'contractdepartments' => $this->contractdepartments,
            'employee' => $this->employee,
            'role' => $this->role,
            'manager' => $this->manager,
            'department' => $this->department,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate, // Add enddate for validation
            'isperpetual' => $this->isperpetual, // Add isperpetual for validation
            'empnotifications' => $this->empnotifications,
            'selectednotifications' => $this->selectednotifications,
        ], [
            'uploads.*' => 'nullable|file|max:5024',
            'contractdepartments' => 'required|array|min:1',
            'employee' => 'required',
            'role' => 'required',
            'manager' => 'required',
            'department' => 'required',
            'startdate' => 'required',
            'enddate' => 'required_if:isperpetual,false', // Make enddate required if isperpetual is false
            'empnotifications' => 'required_if:isperpetual,false|array|min:1',
            'selectednotifications' => 'required_if:isperpetual,false|array|min:1',
        ], [
            'contractdepartments.required' => 'Please select at least one associated department.', // Custom error message
            'empnotifications.required_if' => 'You must select at least 1 user to receive notifications.', // Custom error message
            'selectednotifications.required_if' => 'Please select at least one notification date.', // Custom error message
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Dispatch the browser event to scroll to the error
            $this->setErrorBag($validator->errors()); // Set the error bag for Livewire
            $this->dispatch('scrollToError');
    
            // Optionally return early to prevent further execution
            return;
        }

        DB::beginTransaction();

        try {
            $isPerPetual = $this->isperpetual == 'true' ? 1 : 0;
            if ($isPerPetual == 1) {
                $this->enddate = null;
            }
            
            // Create a new Employee Contract
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

            // Insert contract departments if any
            if (!empty($this->contractdepartments)) {
                foreach ($this->contractdepartments as $contractdepartment) {
                    DB::table('EmployeeContractBusinessGroups')->insert([
                        'BusinessGroupId' => $contractdepartment,
                        'EmployeeContractId' => $newitem->ID,
                    ]);
                }
            }

            if (!is_null($this->uploads)) {
                foreach ($this->uploads as $photo) {
                    $path = $photo->store('employee_contracts', 'public');
                    $newitem->uploads()->create([
                        'FilePath' => $path,
                        'UploadedBy' => Auth::user()->Name,
                        'UploadedDate' => Carbon::now('AST')->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            if ($isPerPetual == 0) {
                $notifications = [];
                $newEmployee = InternalContacts::find($newitem->EmployeeContactId);
                $newEmployeeName = $newEmployee->FirstName . ' ' . $newEmployee->LastName;

                foreach ($this->selectednotifications as $notification) {
                    $label = '';
                    $difference = Carbon::parse($notification)->diff(Carbon::parse($this->enddate));

                    if ($difference->y > 0) {
                        $label = 'Please be advised that the contract for ' . $newEmployeeName . ' ends in ' . $difference->y . ' year(s), ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                    } elseif ($difference->y < 1 && $difference->m > 0) {
                        $label = 'Please be advised that the contract for ' . $newEmployeeName . ' ends in ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                    } elseif ($difference->y < 1 && $difference->m < 1 && $difference->d > 0) {
                        $label = 'Please be advised that the contract for ' . $newEmployeeName . ' ends in ' . $difference->d . ' day(s) on ' . Carbon::parse($this->enddate)->format('F jS, Y');
                    }

                    $notifications[] = [
                        'label' => $label,
                        'itemname' => $newEmployeeName,
                        'itemcontroller' => 'EmployeeContract',
                        'itemaction' => 'Details',
                        'itemid' => $newitem->ID,
                        'displaydate' => $notification,
                        'typeid' => 2,
                        'statusid' => 1,
                        'statuscreatorid' => Auth::user()->ID,
                        'statuscreationdate' => Carbon::now('AST')->format('Y-m-d H:i:s'),
                    ];
                }

                foreach ($notifications as $notification) {
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

                    $newnotification->internalcontacts()->attach($this->empnotifications);
                }
            }

            // Commit the transaction if all actions are successful
            DB::commit();

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Optionally rethrow the exception or return an error response
            throw $e;
        }

        return redirect()->route('employeecontracts')->with('success', 'Employee Contract created successfully.');
        
    }

    public function addNotification(){
        if($this->notidate == null){
            $this->dispatch('show-alert', message: "Please select a date");
            return;
        }else if (in_array($this->notidate, $this->selectednotifications)){
            $this->dispatch('show-alert', message: "Notification already added");
            return;
        }else if (Carbon::parse($this->notidate) < Carbon::now()){
            $this->dispatch('show-alert', message: "Notification date must be after today's date");
            return;
        }
        $this->selectednotifications[] = $this->notidate;
        $this->notidate = null;
    }

    public function removeNotification($index){
        unset($this->selectednotifications[$index]);
    }
}
