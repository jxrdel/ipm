<div>
    <div class="row" style="margin-top: 10px">
        <div class="col" style="text-align: center;padding-bottom:20px">
        
                <label for="title">Add Company &nbsp;</label>
                <select wire:model="selectedCompany" id="companyID" class="form-select" style="display: inline;width: 400px">
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
                @foreach (session('selectedCompanies', []) as $index => $selectedCompany)
                <tr>
                    <td>{{$selectedCompany['compname']}}</td>
                    <td style="text-align: center">
                        <input wire:click="toggleActive({{$index}})"  type="checkbox" class="btn-check" id="btn-check-active{{$index}}" autocomplete="off" checked>
                        <label class="btn btn-outline-success" for="btn-check-active{{$index}}"><i class="bi bi-check-lg"></i></label>
                    </td>

                    <td style="text-align: center">
                        <input wire:click="toggleMainContact({{$index}})" type="checkbox" class="btn-check" id="btn-check-mc{{$index}}" autocomplete="off">
                        <label class="btn btn-outline-success" for="btn-check-mc{{$index}}"><i class="bi bi-check-lg"></i></label>
                    </td>
                    
                    <td style="text-align: center">
                        <input wire:click="togglePrimaryComp({{$index}})" type="checkbox" class="btn-check" id="btn-check-pc{{$index}}" autocomplete="off">
                        <label class="btn btn-outline-success" for="btn-check-pc{{$index}}"><i class="bi bi-check-lg"></i></label>
                    </td>

                    <td style="text-align: center"><button wire:click="removeCompany({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
