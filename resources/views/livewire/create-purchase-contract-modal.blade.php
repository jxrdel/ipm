<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createPCModal" tabindex="-1" aria-labelledby="createPCModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createPCModalLabel" style="color: black">Create Purchase Contract</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="createPC" action="">
            <div class="modal-body" style="color: black">
                <div class="row">
                    <div  style="display: flex">
                        <label style="margin-top: 5px" for="title">Select Department To Restrict Contract Record to: &nbsp;</label>
                        
                        <select wire:model="departmentaccess" class="form-select" style="display: inline;width: 40%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->ID }}">{{ $department->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>
                    <br>
                    <hr class="border border-secondary border-3 opacity-35" style="margin-top:15px">
                </div>
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Name: &nbsp;</label>
                        <input class="form-control" wire:model="name" type="text" style="margin-left:70px;width: 77%;color:black" required>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Purchased Item: &nbsp;</label>
                        
                        <select wire:model="purchaseditem" class="form-select" style="display: inline;width: 70%; height: 35px" required>
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
                        
                        <select wire:model="manager" class="form-select" style="margin-left:50px;display: inline;width: 76%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName}} {{ $manager->LastName}}</option>
                            @endforeach
            
                        </select>

                    </div>

                    <div wire:ignore class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Internal Contacts: &nbsp;</label>
                        <select wire:model="selectedic" id="internalcontacts" multiple style="margin-left:50px">
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName}} {{ $manager->LastName}}</option>
                            @endforeach
            
                        </select>
                    </div>
                </div>

                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Cost: &nbsp;</label>
                        <input class="form-control" wire:model="cost" type="number" style="margin-left:5rem;width: 150px;color:black" placeholder="0.00">
                    </div>

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
                        <input class="form-control" wire:model="startdate" type="date" style="margin-left:2.5rem;width: 60%;color:black" required>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">End Date: &nbsp;</label>
                        <input wire:ignore class="form-control" wire:model="enddate" id="enddate" type="date" style="margin-left:3rem;width: 60%;color:black">
                    </div>
                </div>

                <div  wire:ignore class="row" style="margin-top: 30px" id="hidden-row">
                    <div class="col" style="display: flex">
                        <div class="col"  style="display: flex">
                            <label style="margin-top: 5px" for="title">Months Before: &nbsp;</label>
                            <input class="form-control" id="monthsbefore" wire:model="monthsbefore" type="number" style="width: 50%;color:black">
                        </div>
                        <div class="col">
                            <label for="notistartdate" id="notistartdate" style="margin-top: 5px"> <i class="far fa-bell"></i> Start Date: </label>
                        </div>
                    </div>

                    
                    <div wire:ignore class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Users to Notify: &nbsp;</label>
                        <select id="notifications" multiple style="margin-left:50px">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->ID }}">{{ $employee->FirstName}} {{ $employee->LastName}}</option>
                            @endforeach
            
                        </select>
                    </div>

                </div>
                
                <div class="row" style="margin-top: 40px">
                    <div class="col" style="text-align: center;padding-bottom:20px">
                    
                            <label for="title">Add External Contact &nbsp;</label>
                            <select wire:model="selectedec" id="companyID" class="form-select" style="display: inline;width: 400px">
                                <option value="">Select a Contact</option>
                                @foreach ($extcontacts as $extcontact)
                                    @if (!in_array($extcontact->ID, $this->excludedContacts))
                                        <option value="{{ $extcontact->ID }}">{{ $extcontact->FirstName}} {{ $extcontact->LastName}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button wire:click.prevent="addEContact()" class="btn btn-primary" style="width: 10rem"><i class="fas fa-plus"></i> Add Contact</button>
                    </div>
                </div>
            
                <div class="row">
                    <table id="compTable" class="table table-hover"  style="width: 90%; margin:auto">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width: 130px; text-align:center">Main Contact</th>
                                <th style="width: 100px; text-align:center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->associatedec as $index => $selectedCompany)
                            <tr>
                                <td>{{$selectedCompany['contactname']}}</td>
                                <td style="text-align: center">
                                    <input wire:click="toggleMainContact({{$index}})" type="checkbox" class="btn-check" id="btn-check-mc{{$index}}" autocomplete="off">
                                    <label class="btn btn-outline-success" for="btn-check-mc{{$index}}"><i class="bi bi-check-lg"></i></label>
                                </td>
                                <td style="text-align: center"><button wire:click="removeContact({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
</div>
