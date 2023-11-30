<div class="card-body">
    <div class="col" style="text-align: center;padding-bottom:20px">
        <form wire:submit.prevent="addRole()" action="" method="POST">

            <label for="title">Add Role &nbsp;</label>
            <select wire:model="selectedRole" id="roleID" class="form-select" style="display: inline;width: 300px" required>
                <option value=""></option>
                @foreach ($roles as $role)
                    @if (!in_array(['roleid' => $role->ID, 'rolename' => $role->Name], session('selectedRoles', [])))
                        <option value="{{ $role->ID }}">{{ $role->Name }} </option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary" style="width: 8rem"><i class="fas fa-plus"></i> Add Role</button>
        </form>
    </div>

    <table id="roleTable" class="table table-hover">
        <thead>
            <tr>
                <th>Roles</th>
                <th style="width: 70px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('selectedRoles', []) as $index => $selectedRole)
            <tr>
                <td>{{$selectedRole['rolename']}}</td>
                <td style="text-align: center"><button wire:click="removeRole({{ $index }})" type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
