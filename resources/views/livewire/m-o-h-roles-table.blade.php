<div wire:ignore>
    <table id="rolestable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Role</th>
                <th style="text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mohroles as $role)
            <tr>
                <td>{{ $role->Name }}</td>
                <td><a href="#" onclick="showEdit('{{$role->ID}}')">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
