<div class="card-body">
    <div class="col" style="text-align: center;padding-bottom:20px">
        <form wire:submit.prevent="addPermissionGroup()" action="" method="POST">

            <label for="title">Add Group &nbsp;</label>
            <select wire:model="selectedPGroup" id="pgID" class="form-select" style="display: inline;width: 300px" required>
                <option value=""></option>
                @foreach ($pgroups as $pgroup)
                    @if (!in_array(['pgroupid' => $pgroup->ID, 'pgroupname' => $pgroup->Name], session('selectedPGroups', [])))
                        <option value="{{ $pgroup->ID }}">{{ $pgroup->Name }} </option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary" style="width: 8rem"><i class="fas fa-plus"></i> Add Group</button>
        </form>
    </div>

    <table id="pgTable" class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('selectedPGroups', []) as $index => $selectedPGroup)
            <tr>
                <td>{{$selectedPGroup['pgroupname']}}</td>
                <td style="text-align: center"><button wire:click="removePermissionGroup({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
