<div>
    <form wire:submit.prevent="save" class="card">
        <div class="card-body" style="color: black">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <a href="{{ route('leave.index') }}" class="btn btn-dark">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <h1 class="h3 mb-0 text-gray-800" style="flex: 1; text-align: center;">
                    <strong style="margin-right: 90px"> &nbsp; Create Leave</strong>
                </h1>
            </div>
            <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="leave_type" class="form-label">Leave Type</label>
                    <select wire:model.live="leave_type" id="leave_type" class="form-select">
                        <option value="">Select a leave type</option>
                        @foreach ($leaveTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('leave_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="internal_contact_id" class="form-label">Employee</label>
                    <select wire:model="internal_contact_id" id="internal_contact_id" class="form-select">
                        <option value="">Select an Employee</option>
                        @foreach ($internalContacts as $contact)
                            <option value="{{ $contact->ID }}">{{ $contact->FirstName }} {{ $contact->LastName }}
                            </option>
                        @endforeach
                    </select>
                    @error('internal_contact_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" wire:model.live="start_date" id="start_date" class="form-control">
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" wire:model.live="end_date" id="end_date" class="form-control">
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="days_to_be_taken" class="form-label">Days To Be Taken</label>
                    <input type="number" wire:model="days_to_be_taken" id="days_to_be_taken" class="form-control">
                    @error('days_to_be_taken')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="days_remaining" class="form-label">Days Remaining</label>
                    <input type="number" wire:model="days_remaining" id="days_remaining" class="form-control"
                        min="0">
                    @error('days_remaining')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if (!empty($overlappingLeaves))
                <div class="alert alert-warning mt-3">
                    <strong>Warning:</strong> There are other employees from the same department on leave during this period:
                    <ul>
                        @foreach ($overlappingLeaves as $leave)
                            <li>
                                <strong>{{ $leave->internalContact->FirstName }} {{ $leave->internalContact->LastName }}</strong>:
                                {{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                                ({{ \App\Enums\LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() ?? $leave->leave_type }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
