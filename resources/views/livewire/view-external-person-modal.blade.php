<!-- Modal -->
<div class="modal fade" id="viewEPModal" tabindex="-1" aria-labelledby="viewEPModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewEPModalLabel" style="color: black">{{ $this->firstname }} {{ $this->lastname }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label>First Name: {{ $this->firstname }}</label>
                    </div>
                    <div class="col">
                        <label>Last Name: {{$this->lastname}} </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label> Other Name: {{ $this->othername }}</label>
                    </div>
                    <div class="col">
                        <label> Email: {{$this->email}} </label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> Address 1: {{ $this->address1 }}</label>
                    </div>
                    <div class="col">
                        <label> Address 2: {{$this->address2}} </label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label> Primary Phone: {{ $this->phone1 }}</label>
                    </div>
                    <div class="col">
                        <label> Secondary Phone: {{$this->phone2}} </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label> Active: <i class="{{ $this->isactive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></label>
                    </div>
                    <div class="col">
                        <label>Note: {{$this->note}} </label>
                    </div>
                </div>

                <div class="accordion" id="accordionExample" style="margin-top: 15px">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          List Associated Persons [{{$this->associationcount}}]
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                @if ($this->compassociations !== null)
                                    @foreach ($this->compassociations as $compassociation)
                                        <li> <div class="row">
                                                <div class="col-4">{{$compassociation->CompanyName}}</div>
                                                <div class="col">
                                                    Active: <i class="{{ $compassociation->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
                                                    &nbsp; Primary Person: <i class="{{ $compassociation->IsPrimaryPerson == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
                                                    &nbsp; Primary Company: <i class="{{ $compassociation->IsPrimaryCompany == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
                                                </div>
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
