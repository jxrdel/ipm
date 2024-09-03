<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editECModal" tabindex="-1" aria-labelledby="editECModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editECModalLabel" style="color: black">Create Employee Contract</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="editEC" action="">
            <div class="modal-body" style="color: black">
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Employee: &nbsp;</label>
                        <select wire:model="employee" class="form-select" style="margin-left:40px;display: inline;width: 76%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->ID }}">{{ $employee->FirstName}} {{ $employee->LastName}}</option>
                            @endforeach
            
                        </select>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Role: &nbsp;</label>
                        
                        <select wire:model="role" class="form-select" style="margin-left:80px;display: inline;width: 70%; height: 35px" required>
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
                        
                        <select wire:model="manager" class="form-select" style="margin-left:50px;display: inline;width: 76%; height: 35px" required>
                            <option value=""></option>
                            @foreach ($managers as $manager)
                                <option value="{{ $manager->ID }}">{{ $manager->FirstName}} {{ $manager->LastName}}</option>
                            @endforeach
            
                        </select>

                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Department: &nbsp;</label>
                        
                        <select wire:model="department" class="form-select" style="margin-left:25px;display: inline;width: 70%; height: 35px" required>
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
                            <input wire:model="isperpetual" value="true" type="radio" class="btn-check" name="options-edited" id="editperpetualradio" autocomplete="off" disabled>
                            <label class="btn btn-outline-primary" for="editperpetualradio">Perpetual</label>&nbsp;&nbsp;
    
                            <input wire:model="isperpetual" value="false" type="radio" class="btn-check" name="options-edited" id="editenddateradio" autocomplete="off" disabled>
                            <label class="btn btn-outline-primary" for="editenddateradio">End Date</label>
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
