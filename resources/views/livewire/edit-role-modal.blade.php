<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel" style="color: black">Edit Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form wire:submit.prevent="editRole" action="">
          <div class="modal-body">
              <div class="input-group mb-3">
                  <input id="mohroleid" type="text" wire:model="mohroleid" class="form-control" placeholder="Enter Role Name" aria-label="Role Name" required style="display: none">
                  <input id="mohroletext" type="text" wire:model="mohrole" class="form-control" placeholder="Enter Role Name" aria-label="Role Name" required>
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
