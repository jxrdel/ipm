<?php

namespace App\Livewire;

use App\Enums\LeaveTypeEnum;
use App\Models\InternalContacts;
use App\Models\Leave;
use App\Models\LeaveUpload;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class ViewLeave extends Component
{
    use WithFileUploads;

    public Leave $leave;

    public $leave_type;
    public $start_date;
    public $end_date;
    public $internal_contact_id;
    public $days_remaining;
    public $days_to_be_taken;
    public $uploads = [];

    public $leaveTypes = [];
    public $internalContacts = [];
    public $overlappingLeaves = [];

    #[Title('View Leave')]
    public function mount(Leave $leave)
    {
        $this->leave = $leave;
        $this->leave_type = $leave->leave_type;
        $this->start_date = Carbon::parse($leave->start_date)->format('Y-m-d');
        $this->end_date = Carbon::parse($leave->end_date)->format('Y-m-d');
        $this->internal_contact_id = $leave->internal_contact_id;
        $this->days_remaining = $leave->days_remaining;
        $this->days_to_be_taken = $leave->days_to_be_taken;

        $this->leaveTypes = LeaveTypeEnum::getValues();
        $this->internalContacts = InternalContacts::orderBy('FirstName')->orderBy('LastName')->get();
        $this->updateLeaveDetails();
    }

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
                $this->days_to_be_taken = $startDate->diffInDays($endDate) + 1;
            } else {
                $period = CarbonPeriod::create($startDate, $endDate);
                $days = 0;
                foreach ($period as $date) {
                    if ($date->isWeekday()) {
                        $days++;
                    }
                }
                $this->days_to_be_taken = $days;
            }

            if ($this->internal_contact_id && ($this->leave_type === LeaveTypeEnum::VACATION_LEAVE->value || $this->leave_type === LeaveTypeEnum::CASUAL_LEAVE->value)) {
                $selectedContact = InternalContacts::find($this->internal_contact_id);
                if ($selectedContact && $selectedContact->BusinessGroupId) {
                    $departmentId = $selectedContact->BusinessGroupId;

                    $this->overlappingLeaves = Leave::whereHas('internalContact', function ($query) use ($departmentId) {
                        $query->where('BusinessGroupId', $departmentId);
                    })
                        ->where('id', '!=', $this->leave->id)
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

    public function removeNewUpload($index)
    {
        array_splice($this->uploads, $index, 1);
    }

    public function deleteUpload($uploadId)
    {
        $upload = LeaveUpload::findOrFail($uploadId);
        Storage::disk('public')->delete($upload->file_path);
        $upload->delete();
        $this->leave->refresh(); // Refresh the leave model to update uploads relationship
        session()->flash('success', 'File deleted successfully.');
    }

    public function update()
    {
        $this->validate([
            'leave_type' => 'required|in:' . implode(',', array_keys(LeaveTypeEnum::getValues())),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'internal_contact_id' => 'required|exists:InternalContacts,ID',
            'days_remaining' => 'nullable|integer|min:0',
            'days_to_be_taken' => 'required|integer|min:0',
            'uploads.*' => 'nullable|file|max:10240', // 10MB Max
        ]);

        $this->leave->update([
            'leave_type' => $this->leave_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'internal_contact_id' => $this->internal_contact_id,
            'days_remaining' => $this->days_remaining,
            'days_to_be_taken' => $this->days_to_be_taken,
        ]);

        foreach ($this->uploads as $upload) {
            $path = $upload->store('leave-uploads', 'public');
            LeaveUpload::create([
                'leave_id' => $this->leave->id,
                'file_path' => $path,
                'original_name' => $upload->getClientOriginalName(),
            ]);
        }

        $this->uploads = []; // Clear the new uploads array
        $this->leave->refresh(); // Refresh the leave model to get the latest uploads

        session()->flash('success', 'Leave record updated successfully.');

        // This is to make Alpine see the change and switch back to view mode.
        $this->dispatch('leave-updated');
    }

    public function render()
    {
        return view('livewire.view-leave');
    }
}