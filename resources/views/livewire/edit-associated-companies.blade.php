<div>
    <div class="row" style="margin-top: 10px">
        <input class="form-control" wire:model="personid" type="text" style="width: 95%;color:black">
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
            </tbody>
        </table>
    </div>
</div>
