<div x-data="{ isEditing: false }" @leave-updated.window="isEditing = false">
    <form wire:submit.prevent="update" class="card">
        <div class="card-body" style="color: black">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <a href="{{ route('leave.index') }}" class="btn btn-dark">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <h1 class="h3 mb-0 text-gray-800" style="flex: 1; text-align: center;">
                    <strong style="margin-right: 90px"> &nbsp; View Leave</strong>
                </h1>
                <button type="button" class="btn btn-primary" @click="isEditing = !isEditing"
                    x-text="isEditing ? 'Cancel' : 'Edit'"></button>
            </div>
            <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="leave_type" class="form-label">Leave Type</label>
                    <select wire:model.live="leave_type" id="leave_type" class="form-select" :disabled="!isEditing">
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
                    <select wire:model.live="internal_contact_id" id="internal_contact_id" class="form-select"
                        :disabled="!isEditing">
                        <option value="">Select an Employee</option>
                        @foreach ($internalContacts as $contact)
                            <option value="{{ $contact->ID }}" @if ($contact->ID == $internal_contact_id) selected @endif>
                                {{ $contact->FirstName }} {{ $contact->LastName }}
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
                    <input type="date" wire:model.live="start_date" id="start_date" class="form-control"
                        :disabled="!isEditing">
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" wire:model.live="end_date" id="end_date" class="form-control"
                        :disabled="!isEditing">
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="days_to_be_taken" class="form-label">Days Applied For</label>
                    <input type="number" wire:model="days_to_be_taken" id="days_to_be_taken" class="form-control"
                        :disabled="!isEditing">
                    @error('days_to_be_taken')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="days_remaining" class="form-label">Days Remaining</label>
                    <input type="number" wire:model="days_remaining" id="days_remaining" class="form-control"
                        min="0" :disabled="!isEditing">
                    @error('days_remaining')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr>

            <h5 class="mt-4">Attachments</h5>

            <div x-show="isEditing">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="uploads" class="form-label">Add Attachments</label>
                        <input type="file" wire:model="uploads" id="uploads" class="form-control" multiple>

                        <div wire:loading wire:target="uploads">Uploading...</div>

                        @error('uploads.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->leave->uploads as $upload)
                        <tr>
                            <td>
                                <a href="{{ asset('storage/' . $upload->file_path) }}"
                                    target="_blank">{{ $upload->original_name }}</a>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="deleteUpload({{ $upload->id }})"
                                    wire:confirm="Are you sure you want to delete this file?"
                                    :disabled="!isEditing">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No attachments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="card-footer text-center" x-show="isEditing">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="update, uploads">
                <span>Save</span>
                <span wire:loading wire:target="update" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
            </button>
        </div>
    </form>
</div>
