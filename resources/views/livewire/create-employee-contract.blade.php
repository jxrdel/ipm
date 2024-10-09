<div class="card" x-data="{ isperpetual: $wire.entangle('isperpetual') }">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="{{route('employeecontracts')}}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <h1 class="h3 mb-0 text-gray-800" style="flex: 1; text-align: center;">
                <strong style="margin-right: 90px"> &nbsp; Create Employee Contract</strong>
            </h1>
        </div>
        <form wire:submit.prevent="createEC" action="">
            <div class="modal-body" style="color: black">

                @error('contractdepartments')
                    <div class="row text-danger text-center is-invalid" style="margin-top:10px">
                        <div class="col"></div>
                        <div class="col">{{$message}}</div>
                    </div>
                @enderror
                
                <div class="row">
                    <div  style="display: flex">
                        <div class="col-5">
                            <label style="margin-top: 5px" for="title">Select Departments To Restrict Contract Record to: &nbsp;</label>
                        </div>
                        
                        <div class="col" wire:ignore>
                            <select id="contractdepartments" multiple style="margin-left:50px;width:100%">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->ID }}">{{ $department->Name }} </option>
                                @endforeach
                
                            </select>
                        </div>
                    </div>
                    <br>
                    <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">
                </div>
                <div class="row">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Employee: &nbsp;</label>
                        <select wire:model="employee" class="form-select @error('employee')is-invalid @enderror" style="margin-left:40px;display: inline;width: 76%; height: 35px">
                            <option value=""></option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->ID }}">{{ $employee->FirstName}} {{ $employee->LastName}}</option>
                            @endforeach
            
                        </select>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Role: &nbsp;</label>
                        
                        <select wire:model="role" class="form-select @error('role')is-invalid @enderror" style="margin-left:80px;display: inline;width: 70%; height: 35px">
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->ID }}">{{ $role->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>
    
    
                </div>
                
                <div class="row" style="margin-top: 10px">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">File Number: &nbsp;</label>
                        <input class="form-control" wire:model="filenumber" type="text" style="margin-left:24px;width: 77%;color:black">
                    </div>
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">File Name: &nbsp;</label>
                        <input class="form-control" wire:model="filename" type="text" style="margin-left:40px;width: 70%;color:black">
                    </div>
                </div>
    
                
                <div class="row" style="margin-top: 10px">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Details: &nbsp;</label>
                        <textarea class="form-control" wire:model="details" cols="10" rows="2" style="margin-left:70px;color:black"></textarea>
                    </div>
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Online Location: &nbsp;</label>
                        <input class="form-control" wire:model="onlinelocation" type="text" style="width: 70%;color:black">
                    </div>
                </div>
                
                <div class="row" style="margin-top: 10px">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Manager: &nbsp;</label>
                        
                        <select wire:model="manager" class="form-select @error('manager')is-invalid @enderror" style="margin-left:50px;display: inline;width: 76%; height: 35px">
                            <option value=""></option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName}} {{ $manager->LastName}}</option>
                            @endforeach
            
                        </select>
    
                    </div>
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Department: &nbsp;</label>
                        
                        <select wire:model="department" class="form-select @error('department')is-invalid @enderror" style="margin-left:25px;display: inline;width: 70%; height: 35px">
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->ID }}">{{ $department->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>
                </div>
                
                <div class="row" style="margin-top: 10px">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Expiry Type: &nbsp;</label>
                        <div style="margin-left: 30px">
                            <input wire:model="isperpetual" value="true" type="radio" class="btn-check" name="options-outlined" id="perpetualradio" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="perpetualradio">Perpetual</label>&nbsp;&nbsp;
    
                            <input wire:model="isperpetual" value="false" type="radio" class="btn-check" name="options-outlined" id="enddateradio" autocomplete="off">
                            <label class="btn btn-outline-primary" for="enddateradio">End Date</label>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="margin-top: 10px">
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Start Date: &nbsp;</label>
                        <input class="form-control @error('startdate')is-invalid @enderror" wire:model="startdate" type="date" style="margin-left:2.5rem;width: 60%;color:black">
                    </div>
    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">End Date: &nbsp;</label>
                        <input class="form-control @error('enddate')is-invalid @enderror" wire:model="enddate" id="enddate" type="date" style="margin-left:3rem;width: 60%;color:black">
                    </div>
                </div>
    
    
                <div x-transition x-show="isperpetual == 'false'" class="row" style="margin-top: 30px" id="hidden-row">
    
                    <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">
                    <p class="text-center fw-bold fs-5">Notifications</p>
                    
                    @error('empnotifications')
                        <div style="color:red;text-align:center">{{ $message }}</div>
                    @enderror
                    
                    <div wire:ignore class="row" style="display: flex; align-items: center;">
                        <div class="col-2">
                            <label for="title">Users to Notify: &nbsp;</label>
                        </div>
                        <div class="col">
                            <select id="notifiedUsers" multiple style="width: 100%">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->ID }}">{{ $employee->FirstName }} {{ $employee->LastName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
        
                    <div class="row" style="margin-top: 30px">
                        <div class="col" style="text-align: center;padding-bottom:10px">
                        
                                <label for="title">Add Notification &nbsp;</label>
                                <input wire:model="notidate" type="date" class="form-control" style="display: inline;width: 400px">
                                <button wire:click.prevent="addNotification()" class="btn btn-primary" style="width: 12rem"><i class="fas fa-plus"></i> Add Notification</button>
                        </div>
                    </div>
                    

                    @error('selectednotifications')
                        <div class="row text-danger is-invalid" style="margin-top:10px">
                            <div class="col"></div>
                            <div class="col">{{$message}}</div>
                        </div>
                    @enderror
        
                    <div class="row">
                        <table id="notiTable" class="table table-hover table-bordered"  style="width: 90%; margin:auto">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th style="width: 100px; text-align:center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->selectednotifications as $index => $notification)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($notification)->format('F jS, Y') }}</td>
                                    <td style="text-align: center"><button wire:click="removeNotification({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center">No Notifications Added</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
    
                    <hr class="border border-secondary border-3 opacity-35" style="margin-top:35px">
                    <p class="text-center fw-bold fs-5">File Uploads</p> 
        
                    <div class="row">
                        <div class="col" style="text-align: center;padding-bottom:10px">
                        
                                <label for="title">Upload Docuements &nbsp;</label>
                                <input wire:model="uploads" type="file" multiple class="form-control" style="display: inline;width: 400px">
                        </div>
                    </div>
                                
            
                </div>
    
            </div>
            <div class="modal-footer" style="align-items: center">
                <div style="margin:auto">
                    <button class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@script
<script>
    $(document).ready(function() {
        // Initialize select2
        
        $('#contractdepartments').select2();
        
        $('#contractdepartments').on('change', function() {
            var selectedValues = $(this).val(); // Get selected values as an array
            $wire.set('contractdepartments', selectedValues); // Pass selected values to Livewire
        });
        
        $('#notifiedUsers').select2();
        
        $('#notifiedUsers').on('change', function() {
            var selectedValues = $(this).val(); // Get selected values as an array
            $wire.set('empnotifications', selectedValues); // Pass selected values to Livewire
        });
    });
    
    
    $wire.on('scrollToError', () => {
            // Wait for Livewire to finish rendering the error fields
            setTimeout(() => {
                const firstErrorElement = document.querySelector('.is-invalid');
                if (firstErrorElement) {
                    firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorElement.focus(); // Optional: Focus the field
                }
            }, 100); // Adding a small delay (100ms) before scrolling
        });
</script>
@endscript