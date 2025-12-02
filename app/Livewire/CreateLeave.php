<?php

namespace App\Livewire;

use App\Enums\LeaveTypeEnum;
use App\Models\InternalContacts;
use App\Models\Leave;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateLeave extends Component
{
    public $leave_type;
    public $start_date;
    public

        $end_date;
    public $internal_contact_id;
    public $days_remaining;
    public $days_to_be_taken = 0;

    public $leaveTypes = [];
    public $internalContacts = [];

    #[Title('Create Leave')]

    public function mount()
    {
        $this->leaveTypes = LeaveTypeEnum::getValues();
        $this->internalContacts = InternalContacts::orderBy('FirstName')->orderBy('LastName')->get();
    }

    public $overlappingLeaves = [];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['start_date', 'end_date', 'leave_type', 'internal_contact_id'])) {
            $this->updateLeaveDetails();
        }
    }

    private function updateLeaveDetails()
    {
        $this->overlappingLeaves = [];

        if ($this->start_date && $this->end_date && $this->leave_type) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            if ($endDate->isBefore($startDate)) {
                $this->days_to_be_taken = 0;
                return;
            }

            if ($this->leave_type === LeaveTypeEnum::SICK_LEAVE->value) {
                // Count all days for sick leave
                $this->days_to_be_taken = $startDate->diffInDays($endDate) + 1;
            } else {
                // Count only weekdays for other leave types
                $period = CarbonPeriod::create($startDate, $endDate);
                $days = 0;
                foreach ($period as $date) {
                    if ($date->isWeekday()) {
                        $days++;
                    }
                }
                $this->days_to_be_taken = $days;
            }

            // Check for overlapping leaves
            if ($this->internal_contact_id && ($this->leave_type === LeaveTypeEnum::VACATION_LEAVE->value || $this->leave_type === LeaveTypeEnum::CASUAL_LEAVE->value)) {
                $selectedContact = InternalContacts::find($this->internal_contact_id);

                if ($selectedContact && $selectedContact->BusinessGroupId) {
                    $departmentId = $selectedContact->BusinessGroupId;

                    $this->overlappingLeaves = Leave::whereHas('internalContact', function ($query) use ($departmentId) {
                        $query->where('BusinessGroupId', $departmentId);
                    })
                        ->where(function ($query) use ($startDate, $endDate) {
                            $query->where(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $endDate)
                                    ->where('end_date', '>=', $startDate);
                            });
                        })
                        ->where('internal_contact_id', '!=', $this->internal_contact_id)
                        ->with('internalContact')
                        ->get();
                }
            }
        } else {
            $this->days_to_be_taken = 0;
        }
    }

    public function save()
    {
        $this->validate([
            'leave_type' => 'required|in:' . implode(',', array_keys(LeaveTypeEnum::getValues())),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'internal_contact_id' => 'required|exists:InternalContacts,ID',
            'days_remaining' => 'required|integer|min:0',
            'days_to_be_taken' => 'required|integer|min:0',
        ]);

        Leave::create([
            'leave_type' => $this->leave_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'internal_contact_id' => $this->internal_contact_id,
            'days_remaining' => $this->days_remaining,
            'days_to_be_taken' => $this->days_to_be_taken,
        ]);

        session()->flash('success', 'Leave record created successfully.');

        return redirect()->route('leave.index')->with('success', 'Leave record created successfully.');
    }

    public function render()
    {
        return view('livewire.create-leave');
    }
}
