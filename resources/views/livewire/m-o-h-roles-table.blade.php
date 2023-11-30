<div>
    @foreach ($mohroles as $role)
    <tr>
        <td>{{$role->Name}}</td>
        <td style="text-align: center"><button data-bs-toggle="modal" data-bs-target="#exampleModal"  type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></td>
    </tr>
    @endforeach
</div>
