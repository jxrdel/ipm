<div class="card-body">
    <div class="col" style="text-align: center;padding-bottom:20px">
        <form wire:submit.prevent="addPermission()" action="" method="POST">

            <label for="title">Add Permission &nbsp;</label>
            <select wire:model="selectedPermission" id="pID" class="form-select" style="display: inline;width: 300px" required>
                <option value=""></option>
                @foreach ($permissions as $permission)
                    @if (!in_array(['permissionid' => $permission->ID, 'permissionname' => $permission->Description], session('selectedPermissions', [])))
                        <option value="{{ $permission->ID }}">{{ $permission->Description }} </option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary" style="width: 10rem"><i class="fas fa-plus"></i> Add Permission</button>
        </form>
    </div>

    <table id="pTable" class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('selectedPermissions', []) as $index => $selectedPermission)
            <tr>
                <td>{{$selectedPermission['permissionname']}}</td>
                <td style="text-align: center"><button wire:click="removePermission({{$index}})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
