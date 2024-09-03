<!-- Modal -->
<div class="modal fade" id="viewPCModal" tabindex="-1" aria-labelledby="viewPCModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewPCModalLabel" style="color: black">{{ $this->name }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label> <strong>Name: </strong>{{ $this->name }}</label>
                    </div>
                    <div class="col">
                        <label><strong>Purchased Item: </strong>{{$this->purchaseditem}} </label>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col">
                        <label> <strong>File Number: </strong>{{ $this->filenumber }}</label>
                    </div>
                    <div class="col">
                        <label><strong>File Name: </strong> {{$this->filename}} </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label><strong>Details: </strong> {{ $this->details }}</label>
                    </div>
                    
                    <div class="col">
                        <label><strong>Online Location: </strong> {{ $this->onlinelocation }}</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> <strong>Manager: </strong>{{ $this->manager }}</label>
                    </div>
                    
                    <div class="col">
                        <label> <strong>Internal Contacts:</strong> 
                            @if ($this->internalcontacts)
                                @foreach ($this->internalcontacts as $index => $contact)
                                    • {{$contact->FirstName}} {{$contact->LastName}}
                                @endforeach
                            @endif
                        </label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> <strong>Cost: </strong>{{ $this->cost }}</label>
                    </div>
                    
                    <div class="col">
                        <label> <strong>Expiry Type: </strong>{{ $this->isperpetual == 1 ? 'Perpetual' : 'Not Perpetual' }}</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> <strong>Start Date: </strong>{{ $this->startdate }}</label>
                    </div>
                    
                    <div class="col">
                        <label> <strong>End Date: </strong>{{ $this->enddate }}</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> <strong>External Contacts:</strong> 
                            @if ($this->externalcontacts)
                                @foreach ($this->externalcontacts as $index => $contact)
                                    • {{$contact->FirstName}} {{$contact->LastName}}
                                @endforeach
                            @endif
                        </label>
                    </div>
                    
                </div>

                <div class="accordion" id="accordionExample" style="margin-top: 15px">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Associated Notifications  [{{$this->notificationcount}}]
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                @if ($this->notifications)
                                    @foreach ($this->notifications as $notification)
                                        <li> <div class="row">
                                                <div class="col-8">{{$notification->Label}}</div>
                                                <div class="col"> Display Date: {{\Carbon\Carbon::parse($notification->DisplayDate)->format('d/m/Y') }}</div>
                                                <div class="col-1">{{$notification->StatusId == 1 ? 'Active' : 'Inactive'}}</div>
                                            </div>
                                        </li>
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
