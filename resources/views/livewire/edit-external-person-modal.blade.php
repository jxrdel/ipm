<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editEPModal" tabindex="-1" aria-labelledby="editEPModalLabel" aria-hidden="true" style="color: black">
    <div class="modal-dialog modal-xl">
        <form wire:submit.prevent="editExternalPerson" action="">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="editEPModalLabel" style="color: black">{{ $this->firstname }} {{ $this->lastname }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
                  <div class="modal-body">
      
                      <div class="row">
                          
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">First Name: &nbsp;</label>
                              <input class="form-control" wire:model="firstname" type="text" style="width: 80%;color:black" required>
                          </div>
                          
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Last Name: &nbsp;</label>
                              <input class="form-control" wire:model="lastname" type="text" style="width: 80%;color:black" required>
                          </div>
      
                      </div>
      
                      <div class="row" style="margin-top: 20px">
      
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Other Name: &nbsp;</label>
                              <input class="form-control" wire:model="othername" type="text" style="width: 80%;color:black">
                          </div>
      
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Email: &nbsp;</label>
                              <input class="form-control" wire:model="email" type="text" style="width: 80%;color:black">
                          </div>
                          
                      </div>
                      
                      <div class="row" style="margin-top: 20px">
      
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Address 1: &nbsp;</label>
                              <input class="form-control" wire:model="address1" type="text" style="width: 80%;color:black">
                          </div>
      
      
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Address 2: &nbsp;</label>
                              <input class="form-control" wire:model="address2" type="text" style="width: 80%;color:black">
                          </div>
                          
                      </div>
                      
                      <div class="row" style="margin-top: 20px">
                          
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Primary Phone: &nbsp;</label>
                              <input class="form-control" wire:model="phone1" type="text" style="width: 60%;color:black" required>
                          </div>
                          
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Secondary Phone: &nbsp;</label>
                              <input class="form-control" wire:model="phone2" type="text" style="width: 70%;color:black">
                          </div>
                          
                      </div>
      
                      <div class="row" style="margin-top: 20px">
                          
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Active: &nbsp;</label>
                              <input style="margin-left: 70px" wire:model="isactive" class="form-check-input" type="checkbox" name="IsActive">
                          </div>
      
                          <div class="col" style="display: flex">
                              <label style="margin-top: 5px" for="title">Note: &nbsp;</label>
                              <input class="form-control" wire:model="note" type="text" style="width: 95%;color:black">
                          </div>
                      </div>
      
                      
                      <div class="row" style="margin-top: 10px">
                          <div class="col" style="text-align: center;padding-bottom:20px">
                          
                                  <label for="title">Add Company &nbsp;</label>
                                  <select wire:model="selectedcompany" id="companyID" class="form-select" style="display: inline;width: 400px">
                                      <option value="">Select a Company</option>
                                      @foreach ($companies as $company)
                                          @if (!in_array($company->ID, $this->excludedCompanies))
                                              <option value="{{ $company->ID }}">{{ $company->CompanyName }} </option>
                                          @endif
                                      @endforeach
                                  </select>
                                  <button wire:click.prevent="addCompany()" class="btn btn-primary" style="width: 10rem"><i class="fas fa-plus"></i> Add Company</button>
                          </div>
                      </div>
      
                      <div class="row">
                          <table id="compTable" class="table table-hover"  style="width: 90%; margin:auto">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th style="width: 100px; text-align:center">Active</th>
                                      <th style="width: 150px; text-align:center">Main Contact</th>
                                      <th style="width: 160px; text-align:center">Primary Company</th>
                                      <th style="width: 100px; text-align:center">Delete</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($this->compassociations as $index => $company)
                                  <tr>
                                      <td>{{$company['CompanyName']}}</td>
                                      <td style="text-align: center">
                                          <input wire:click="toggleActive({{$index}})"  type="checkbox" class="btn-check" id="btn-check-active{{$index}}" autocomplete="off" {{ $company['IsActive'] == 1 ? 'checked' : '' }}>
                                          <label class="btn btn-outline-success" for="btn-check-active{{$index}}"><i class="bi bi-check-lg"></i></label>
                                      </td>
                  
                                      <td style="text-align: center">
                                          <input wire:click="toggleMainContact({{$index}})" type="checkbox" class="btn-check" id="btn-check-mc{{$index}}" autocomplete="off" {{ $company['IsPrimaryPerson'] == 1 ? 'checked' : '' }}>
                                          <label class="btn btn-outline-success" for="btn-check-mc{{$index}}"><i class="bi bi-check-lg"></i></label>
                                      </td>
                                      
                                      <td style="text-align: center">
                                          <input wire:click="togglePrimaryComp({{$index}})" type="checkbox" class="btn-check" id="btn-check-pc{{$index}}" autocomplete="off" {{ $company['IsPrimaryCompany'] == 1 ? 'checked' : '' }}>
                                          <label class="btn btn-outline-success" for="btn-check-pc{{$index}}"><i class="bi bi-check-lg"></i></label>
                                      </td>
                  
                                      <td style="text-align: center"><button wire:click="removeCompany({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="modal-footer" style="align-items: center">
                      <div style="margin:auto">
                        <button class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      </div>
                  </div>
            </div>
        </form>
    </div>
  </div>
