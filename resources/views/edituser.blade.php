@extends('layout')

@section('title')
    <title>IPM | Edit User</title>
@endsection

@section('styles')

@endsection

@section('content')
    

    <form method="POST" id="updateUser" action="{{ route('updateuser') }}">
        @csrf
        @method('PUT')
        <!-- Page Heading -->
        <div class="row">
            <div class="col">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
                </div>
            </div>
            <div class="col" style="text-align: end">
                
                <button type="submit" href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text"  style="width: 70px">Save</span>
                </button> 
                &nbsp;&nbsp;&nbsp;

                <a href="{{ route('userdetails', ['id' => $user->ID]) }}" class="btn btn-outline-secondary" style="width: 7rem">Cancel</a>
                
            </div>
        </div>
        

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">User Name: {{$user->Name}}</div>
                    {{-- <div class="col-2">Active: <i class="{{ $user->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></div> --}}
                    <div class="col-2">Active: 
                        <div class="form-check" style="display: inline; margin-left:10px">
                            <input name="userID" type="text" value="{{$user->ID}}" style="display: none">
                            <input class="form-check-input" type="checkbox" name="IsActive" {{ $user->IsActive == 1 ? 'checked' : '' }}>
                        </div>    
                    </div>
                    <div class="col">
                        <div style="margin-top: -6px">
                            <label for="title">Internal Contact &nbsp;</label>
                            <select name="InternalContactId" class="form-select" style="display: inline;width: 300px">
                                <option value=""></option>
                                @php
                                    $selectedIC = $user->InternalContactId
                                @endphp
                                        
                                @foreach ($internalcontacts as $internalcontact)
                                        <option value="{{ $internalcontact->ID }}" {{ $selectedIC == $internalcontact->ID ? 'selected' : '' }}>{{ $internalcontact->FirstName }} {{ $internalcontact->LastName }}</option>
                                @endforeach
                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <div class="row" style="padding-top: 30px">
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Roles</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="col" style="text-align: center;padding-bottom:20px">
                            <form method="POST" id="addrole" action="{{ route('addrole', ['id' => $user->ID])}}">
                                @csrf
                                @method('PUT')
                                <label for="title">Add Role &nbsp;</label>
                                <select name="RoleId" class="form-select" style="display: inline;width: 300px" required>
                                    <option value=""></option>
                                            
                                    @foreach ($availableroles as $role)
                                            <option value="{{ $role->ID }}">{{ $role->Name }} </option>
                                    @endforeach
                    
                                </select>
                                <button type="submit" class="btn btn-primary" style="width: 8rem"><i class="fas fa-plus"></i> Add Role</button>
                            </form>
                        </div>
                        @if (count($roles) > 0)
                            <table id="roleTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                        <th style="width: 70px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->Name }}</td>
                                        <td style="text-align: center"><a href="{{ route('deleterole', ['id' => $role->ID, 'userid' => $user->ID]) }}"><button type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No roles assigned to this user</p>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 30px">
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Permission Groups</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        
                        <div class="col" style="text-align: center;padding-bottom:20px">
                            <form method="POST" id="addpgroup" action="{{ route('addpgroup', ['id' => $user->ID])}}">
                                @csrf
                                @method('PUT')
                                <label for="title">Add Permission Group &nbsp;</label>
                                <select name="GroupID" class="form-select" style="display: inline;width: 300px" required>
                                    <option value=""></option>
                                            
                                    @foreach ($availablegroups as $group)
                                            <option value="{{ $group->ID }}">{{ $group->Name }} </option>
                                    @endforeach
                    
                                </select>
                                <button type="submit" class="btn btn-primary" style="width: 8rem"><i class="fas fa-plus"></i> Add Group</button>
                            </form>
                        </div>

                        @if (count($permissiongroups) > 0)
                            <table id="pgTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Groups</th>
                                        <th style="width: 70px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissiongroups as $permissiongroup)
                                    <tr>
                                        <td>{{ $permissiongroup->Name }}</td>
                                        <td style="text-align: center"><a href="{{ route('deletepgroup', ['id' => $permissiongroup->ID, 'userid' => $user->ID]) }}"><button type="button" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No permission groups assigned to this user</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Menu Headers</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if (count($menuheaders) > 0)
                            <table id="mhTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Menu Headers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menuheaders as $menuheader)
                                    <tr>
                                        <td>{{ $menuheader }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No menu headers assigned to this user</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        
        <hr class="border border-primary border-3 opacity-35">

        <div class="row" style="padding-top: 10px; padding-bottom:30px;">
            <div class="col">
                <a href="#" class="btn btn-danger btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">Delete</span>
                </a>
            </div>
        </div>
@endsection

@section('scripts')
@if (Session::has('success'))

  <script>
      toastr.options = {
        "progressBar" : true,
        "closeButton" : true,
      }
      toastr.success("{{ Session::get('success') }}",'' , {timeOut:3000});
  </script>

@endif
    <script>
        
        $(document).ready(function() {
            $('#roleTable').DataTable({
                paging: false,
                searching:false
            });

            $('#pgTable').DataTable({
                paging: false,
                searching:false,
                scrollCollapse: true,
                scrollY: '150px'
            });

            $('#spTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '150px'
            });

            $('#mhTable').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '150px'
            });
        });
    </script>

    
    <script>
        $(document).ready(function(){
        // Show the collapse on page load
        $("#UserControlCollapse").collapse('show');
        });
        $(document).ready(function(){
        // Show the collapse on page load
        $("#UserAccCollapse").collapse('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activeheader = document.getElementById('useraccheader');

        // Set the fontWeight property to 'bold'
        activeheader.style.fontWeight = 'bold';
        });
    </script>
    
@endsection