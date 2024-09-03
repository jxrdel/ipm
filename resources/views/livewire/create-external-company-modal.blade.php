<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel" style="color: black">Create Role</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="createExternalCompany" action="">
            <div class="modal-body" style="color: black">
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Company name: &nbsp;</label>
                        <input class="form-control" wire:model="compname" type="text" style="width: 80%;color:black" required>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Email: &nbsp;</label>
                        <input class="form-control" wire:model="email" type="email" style="width: 90%;color:black" required>
                    </div>

                </div>
                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Address Line 1: &nbsp;</label>
                        <input class="form-control" wire:model="address1" type="text" style="width: 80%;color:black" required>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Address Line 2: &nbsp;</label>
                        <input class="form-control" wire:model="address2" type="text" style="width: 80%;color:black">
                    </div>

                </div>

                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Primary Phone: &nbsp;</label>
                        <input class="form-control" wire:model="phone1" type="text" style="width: 300px;color:black" required>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Secondary Phone: &nbsp;</label>
                        <input class="form-control" wire:model="phone2" type="text" style="width: 300px;color:black">
                    </div>

                </div>
                
                <div class="row" style="margin-top: 30px">
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Note: &nbsp;</label>
                        <input class="form-control" wire:model="note" type="text" style="width: 95%;color:black">
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Active: &nbsp;</label>
                        <input style="margin-left: 70px" wire:model="isactive" class="form-check-input" type="checkbox" name="IsActive" checked>
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
