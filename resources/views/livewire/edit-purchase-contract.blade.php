<div class="card" x-data="{
    is_custom_notification: $wire.entangle('is_custom_notification'),

}">
    @include('livewire.add-notification-modal')
    <div class="card-body">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('purchasecontracts') }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <h1 class="h3 mb-0 text-gray-800" style="flex: 1; text-align: center;">
                <strong style="margin-right: 90px"> &nbsp; Edit Purchase Contract</strong>
            </h1>
        </div>
        <form wire:submit.prevent="editPC" action="">
            <div class="modal-body" style="color: black">
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Name: &nbsp;</label>
                        <input class="form-control" wire:model="name" type="text"
                            style="margin-left:70px;width: 77%;color:black" required>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Purchased Item: &nbsp;</label>

                        <select wire:model="purchaseditem" class="form-select"
                            style="display: inline;width: 70%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->ID }}">{{ $purchase->Name }} </option>
                            @endforeach

                        </select>
                    </div>


                </div>

                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">File Number: &nbsp;</label>
                        <input class="form-control" wire:model="filenumber" type="text"
                            style="margin-left:24px;width: 77%;color:black">
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">File Name: &nbsp;</label>
                        <input class="form-control" wire:model="filename" type="text"
                            style="margin-left:40px;width: 70%;color:black">
                    </div>
                </div>


                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Details: &nbsp;</label>
                        <textarea class="form-control" wire:model="details" cols="10" rows="2" style="margin-left:70px;color:black"></textarea>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Online Location: &nbsp;</label>
                        <input class="form-control" wire:model="onlinelocation" type="text"
                            style="width: 70%;color:black">
                    </div>
                </div>

                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Manager: &nbsp;</label>

                        <select wire:model="manager" class="form-select"
                            style="margin-left:50px;display: inline;width: 76%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName }} {{ $manager->LastName }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Cost: &nbsp;</label>
                        <input class="form-control" wire:model="cost" type="text"
                            style="margin-left:5rem;width: 150px;color:black" placeholder="0.00">
                    </div>
                </div>


                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Start Date: &nbsp;</label>
                        <input class="form-control" wire:model="startdate" type="date"
                            style="margin-left:2.5rem;width: 60%;color:black" required>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">End Date: &nbsp;</label>
                        <input wire:ignore class="form-control" wire:model="enddate" id="enddateedit" type="date"
                            style="margin-left:3rem;width: 60%;color:black">
                    </div>
                </div>

                <div wire:ignore class="row" style="margin-top: 10px">
                    <div class="col-2">
                        <label style="margin-top: 5px" for="title">Internal Contacts: &nbsp;</label>
                    </div>

                    <div class="col">
                        <select style="width: 100%" id="internalContactSelect" class="js-example-basic-multiple"
                            multiple="multiple">
                            <option value="">Select an Internal Contacts</option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName }} {{ $manager->LastName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top: 30px" id="hidden-row-edit">

                    <div class="col">
                    </div>
                </div>


                <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">
                <p class="text-center fw-bold fs-5">Notifications</p>

                <div wire:ignore class="row" style="margin-top: 10px">
                    <div class="col-2">
                        <label style="margin-top: 5px" for="title">Notified Users: &nbsp;</label>
                    </div>

                    <div class="col">
                        <select style="width: 100%" id="notifiedUsersSelect" class="js-example-basic-multiple"
                            multiple="multiple">
                            <option value="">Select an Internal Contacts</option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName }}
                                    {{ $manager->LastName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top: 30px">
                    <div class="col" style="text-align: center;padding-bottom:10px">

                        {{-- <label for="title">Add Notification &nbsp;</label>
                        <input wire:model="notidate" type="date" class="form-control"
                            style="display: inline;width: 400px">
                        <button wire:click.prevent="addNotification()" class="btn btn-primary"
                            style="width: 12rem"><i class="fas fa-plus"></i> Add Notification</button> --}}

                        <a type="button" data-bs-toggle="modal" data-bs-target="#addNotificationModal"
                            class="btn btn-primary btn-icon-split" style="width: 12rem">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text" style="width: 200px">Add Notification</span>
                        </a>
                    </div>
                </div>

                <div class="row mt-3">
                    <table id="notiTable" class="table table-hover table-bordered" style="width: 100%; margin:auto">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th style="width: 200px; text-align:center">Custom Notification</th>
                                <th>Notification Message</th>
                                <th style="width: 100px; text-align:center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $index => $notification)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($notification['DisplayDate'])->format('F jS, Y') }}
                                    </td>
                                    <td style="text-align: center"><i
                                            class="{{ $notification['IsCustomNotification'] ? 'fa-solid fa-check' : 'fa-solid fa-xmark' }}"></i>
                                    </td>
                                    <td>
                                        @if ($notification['IsCustomNotification'])
                                            {{ $notification['NotificationMessage'] }}
                                        @else
                                            Default reminder
                                        @endif
                                    </td>
                                    <td style="text-align: center"><button
                                            wire:click="removeNotification({{ $index }})" type="button"
                                            class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="2" style="text-align: center">No Notifications</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <hr class="border border-secondary border-3 opacity-35" style="margin-top:35px">
                <p class="text-center fw-bold fs-5">External Contacts</p>

                <div class="row" style="margin-top: 40px">
                    <div class="col" style="text-align: center;padding-bottom:20px">

                        <label for="title">Add External Contact &nbsp;</label>
                        <select wire:model="selectedec" id="companyID" class="form-select"
                            style="display: inline;width: 400px">
                            <option value="">Select a Contact</option>
                            @foreach ($extcontacts as $extcontact)
                                @if (!in_array($extcontact->ID, $this->excludedEC))
                                    <option value="{{ $extcontact->ID }}">{{ $extcontact->FirstName }}
                                        {{ $extcontact->LastName }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button wire:click.prevent="addExternalContact()" class="btn btn-primary"
                            style="width: 10rem"><i class="fas fa-plus"></i> Add Contact</button>
                    </div>
                </div>

                <div class="row">
                    <table id="compTable" class="table table-hover" style="width: 90%; margin:auto">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width: 130px; text-align:center">Main Contact</th>
                                <th style="width: 100px; text-align:center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->associatedec as $index => $contact)
                                <tr>
                                    <td>{{ $contact['FirstName'] }} {{ $contact['LastName'] }}</td>
                                    <td style="text-align: center">
                                        <input wire:click="toggleMainContact({{ $index }})" type="checkbox"
                                            class="btn-check" id="btn-check-mc{{ $index }}"
                                            autocomplete="off" {{ $contact['IsPrimary'] == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success"
                                            for="btn-check-mc{{ $index }}"><i
                                                class="bi bi-check-lg"></i></label>
                                    </td>
                                    <td style="text-align: center"><button
                                            wire:click="removeExternalContact({{ $index }})" type="button"
                                            class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="border border-secondary border-3 opacity-35" style="margin-top:35px">
                <p class="text-center fw-bold fs-5">File Uploads</p>

                <div class="row">
                    <div class="col" style="text-align: center;padding-bottom:10px">

                        <label for="title">Upload Docuements &nbsp;</label>
                        <input wire:model="uploadInput" type="file" class="form-control"
                            style="display: inline;width: 400px">
                        <button wire:click.prevent="uploadFiles()" class="btn btn-primary" wire:loading.remove
                            wire:target="uploadInput" style="width: 8rem"><i class="fas fa-plus"></i>
                            Upload</button>
                        <span wire:loading wire:target="uploadInput">Uploading...</span>
                    </div>
                </div>

                <div class="row">
                    <table id="compTable" class="table table-hover" style="width: 90%; margin:auto">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width: 100px; text-align:center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fileuploads as $index => $file)
                                <tr>
                                    <td><a href="{{ Storage::url($file->FilePath) }}" target="_blank">File
                                            {{ $index + 1 }} <i
                                                class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                                    <td style="text-align: center"><button
                                            wire:confirm="Are you sure you want to delete this file?"
                                            wire:click="deleteUpload({{ $file->ID }})" type="button"
                                            class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center">No Files Uploaded</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer" style="align-items: center">
                <div style="margin:auto">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('purchasecontracts') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            // Initialize select2

            $('#internalContactSelect').select2();
            $('#internalContactSelect').val(@json($this->associatedic)).trigger('change');
            $wire.set('editedIC', []); // Initiates value to an empty array
            $wire.set('isEditedIC', false); // Set the flag to false

            $('#internalContactSelect').on('change', function() {
                var selectedValues = $(this).val(); // Get selected values as an array
                $wire.set('editedIC', selectedValues); // Pass selected values to Livewire
                $wire.set('isEditedIC', true); // Set the flag to true
            });


            $('#notifiedUsersSelect').select2();
            $('#notifiedUsersSelect').val(@json($this->usernotifications)).trigger('change');
            $wire.set('editedNU', []); // Initiates value to an empty array
            $wire.set('isEditedNU', false); // Set the flag to false

            $('#notifiedUsersSelect').on('change', function() {
                var selectedValues = $(this).val(); // Get selected values as an array
                $wire.set('editedUN', selectedValues); // Pass selected values to Livewire
                $wire.set('isEditedUN', true); // Set the flag to true
            });

            $wire.on('close-notification-modal', () => {
                $('#addNotificationModal').modal('hide');
            });


            window.addEventListener('show-alert', event => {
                var message = event.detail.message;

                // Display an alert with the received message
                alert(message);
            })
        });
    </script>
@endscript
