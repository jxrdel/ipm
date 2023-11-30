<!-- Modal -->
<div class="modal fade" id="viewICModal" tabindex="-1" aria-labelledby="viewICModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="viewICModalLabel" style="color: black">{{ $this->firstname }} {{ $this->lastname }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label> Name: {{ $this->firstname }} {{ $this->lastname }}</label>
                    </div>
                    <div class="col">
                        <label>Email {{$this->email}} </label>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col">
                        <label> Role: {{ $this->role }}</label>
                    </div>
                    <div class="col">
                        <label>Department: {{$this->department}} </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label> Active: {{ $this->isactive }}</label>
                    </div>
                    <div class="col">
                        <label>Ext: {{$this->extno}} </label>
                    </div>
                </div>

                <div class="row" style="margin-top: 30px">
                    <a class="btn btn-primary" href="#" style="width: 10rem; margin:auto;"><i class="fas fa-plus"></i> Add Contract</a>
                </div>

                <div class="accordion" id="accordionExample" style="margin-top: 15px">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          List Associated Contracts [{{$this->contractcount}}]
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                @if ($this->contracts !== null)
                                    @foreach ($this->contracts as $contract)
                                        <li>{{ \Carbon\Carbon::parse($contract->StartDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($contract->EndDate)->format('d/m/Y') }}</li>
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
