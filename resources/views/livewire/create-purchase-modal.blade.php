<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createPurchaseModal" tabindex="-1" aria-labelledby="createPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createPurchaseModalLabel" style="color: black">Create Purchase</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="createPurchase" action="">
            <div class="modal-body" style="color: black">
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Name: &nbsp;</label>
                        <input class="form-control" wire:model="name" type="text" style="width: 80%;color:black" required>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Company: &nbsp;</label>
                        
                        <select wire:model="company" class="form-select" style="display: inline;width: 400px" required>
                            <option value=""></option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->ID }}">{{ $company->CompanyName }} </option>
                            @endforeach
            
                        </select>
                    </div>

                </div>
                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Type: &nbsp;</label>
                        <select wire:model="type" class="form-select" style="display: inline;width: 300px" required>
                            <option value=""></option>
                            @foreach ($purchasetypes as $purchasetype)
                                <option value="{{ $purchasetype->ID }}">{{ $purchasetype->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Active: &nbsp;</label>
                        <input style="margin-left: 60px; margin-top:10px" wire:model="isactive" class="form-check-input" type="checkbox" name="IsActive" checked>
                    </div>

                </div>

                
                <div class="row" style="margin-top: 30px">
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title">Details: &nbsp;</label>
                        <input class="form-control" wire:model="details" type="text" style="width: 95%;color:black">
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
