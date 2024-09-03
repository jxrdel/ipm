<!-- Modal -->
<div wire:ignore.self class="modal fade" id="viewECModal" tabindex="-1" aria-labelledby="viewECModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewECModalLabel" style="color: black">View Employee Contract</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="ViewEC" action="">
            <div class="modal-body" style="color: black">
                <div class="row">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Employee: </strong>&nbsp;{{$this->employee}}</label>
                    </div>
                    
                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Role: </strong>&nbsp;{{$this->role}}</label>
                    </div>


                </div>
                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>File Number: </strong>&nbsp;{{$this->filenumber}}</label>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>File Name: </strong>&nbsp;{{$this->filename}}</label>
                    </div>
                </div>

                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Details: </strong>&nbsp;{{$this->details}}</label>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Online Location: </strong>&nbsp;{{$this->onlinelocation}}</label>
                    </div>
                </div>
                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Manager: </strong>&nbsp;{{$this->manager}}</label>

                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Department: </strong>&nbsp;{{$this->department}}</label>
                    </div>
                </div>
                
                <div class="row" style="margin-top: 10px">

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>Start Date: </strong>&nbsp;{{$this->startdate}}</label>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="title"><strong>End Date: </strong>&nbsp;{{$this->enddate}}</label>
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
