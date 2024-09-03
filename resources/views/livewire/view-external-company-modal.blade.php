<!-- Modal -->
<div class="modal fade" id="viewECModal" tabindex="-1" aria-labelledby="viewECModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewECModalLabel" style="color: black">{{ $this->compname }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label> Name: {{ $this->compname }}</label>
                    </div>
                    <div class="col">
                        <label>Email: {{$this->email}} </label>
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
                        <label> Active: <i class="{{ $this->isactive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></label>
                    </div>
                    <div class="col">
                        <label>Note: {{$this->note}} </label>
                    </div>
                </div>

                <div class="row" style="margin-top: 30px">
                    <a class="btn btn-primary" href="#" style="width: 10rem; margin:auto;"><i class="fas fa-plus"></i> Add Contract</a>
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
                                @if ($this->empassociations !== null)
                                    @foreach ($this->empassociations as $empassociation)
                                        <li> <div class="row">
                                                <div class="col-4">{{$empassociation->FirstName}} {{$empassociation->LastName}} </div>
                                                <div class="col">
                                                    Active: <i class="{{ $empassociation->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
                                                    &nbsp; Primary Person: <i class="{{ $empassociation->IsPrimaryPerson == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
                                                    &nbsp; Primary Company: <i class="{{ $empassociation->IsPrimaryCompany == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i>
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
