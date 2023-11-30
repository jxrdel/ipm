<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editICModal" tabindex="-1" aria-labelledby="editICModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editICModalLabel" style="color: black">Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="editEmployee" action="">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <input class="form-control" wire:model="employeeid" type="text" name="" style="width: 300px;color:black;display:none" required>
                        <div class="form-floating mb-3">
                            <input wire:model="firstname" type="text" class="form-control" id="floatingInput" placeholder="FirstName" style="color: black" required>
                            <label for="floatingInput" style="color: black">First Name</label>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input wire:model="lastname" type="text" class="form-control" id="floatingInput" placeholder="LastName" style="color: black" required>
                            <label for="floatingInput" style="color: black">Last Name</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label for="title">Role &nbsp;</label>
                        <select wire:model="role" class="form-select" style="display: inline;width: 300px" required>
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->ID }}" {{  $role->ID == $this->role ? 'selected' : '' }}>{{ $role->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Email &nbsp;</label>
                        <input class="form-control" wire:model="email" type="email" name="" required style="width: 300px;color:black">
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Phone Ext. &nbsp;</label>
                        <input class="form-control" wire:model="extno" type="text" name="" style="width: 300px;color:black" required>
                    </div>
                </div>
                <div class="row">
                    <label for="title">Active &nbsp;</label>
                    <input style="margin-left: 70px" wire:model="isactive" class="form-check-input" type="checkbox" name="IsActive" {{ $this->isactive == true ? 'checked' : '' }}>
                </div>

                <div class="row" style="margin-top: 20px">
                    <div class="col">
                        <label for="title">Department &nbsp;</label>
                        <select wire:model="department" class="form-select" style="display: inline;width: 400px">
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->ID }}" {{ $this->department == $department->ID ? 'selected' : '' }}>{{ $department->Name }} </option>
                            @endforeach
            
                        </select>
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
