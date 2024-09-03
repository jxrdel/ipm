<!-- Modal -->
<div class="modal fade" id="viewNotiModal" tabindex="-1" aria-labelledby="viewNotiModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewNotiModalLabel" style="color: black">{{ $this->itemname }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label>ID: {{ $this->notificationid }}</label>
                    </div>
                    <div class="col">
                        <label>Label: {{ $this->label }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Type: {{$this->typeid}} </label>
                    </div>
                    <div class="col">
                        <label>Status: {{ $this->statusid == 1 ? 'Active' : 'Inactive' }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> Status Creator: {{ $this->statuscreator }}</label>
                    </div>
                    <div class="col">
                        <label>Controller: {{$this->controller}} </label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label>Display Date: {{ $this->displaydate }}</label>
                    </div>
                    <div class="col">
                        <label>Status Date: {{$this->statusdate}} </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Item ID: {{ $this->itemid }}</label>
                    </div>
                    <div class="col">
                        <label>Action: {{$this->action}} </label>
                    </div>
                </div>

                <div class="accordion" id="accordionExample" style="margin-top: 15px">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        List of Users Notification is Active for [{{$this->usernotificationcount}}]
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                @if ($this->usernotifications !== null)
                                    @foreach ($this->usernotifications as $user)
                                        <li>{{$user->FirstName}} {{$user->LastName}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            <div class="modal-footer" style="align-items: center">
                <div style="margin:auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
      </div>
    </div>
  </div>
