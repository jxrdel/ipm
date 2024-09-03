@extends('layout')

@section('title')
    <title>IPM | User Details</title>
@endsection

@section('styles')
@endsection

@section('content')
    

        @livewire('view-internal-contact-modal')
        <!-- Page Heading -->
        <div class="row">
            <div class="col">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">User</h1>
                </div>
            </div>
            <div class="col" style="text-align: end">
                
                <a href="{{ route('edituser', ['id' => $user->ID]) }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-user-edit"></i>
                    </span>
                    <span class="text"  style="width: 70px">Edit</span>
                </a> 
                &nbsp;&nbsp;&nbsp;

                <a href="{{ route('listusers')}}" class="btn btn-outline-secondary" style="width: 8rem">Return to List</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">User Name: {{$user->Name}}</div>
                    <div class="col" >Active: <i class="{{ $user->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></div>
                    <div class="col" >System Admin: <i class="{{ $user->IsSysAdmin == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></div>
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col">Contact: <a href="#" onclick="displayIC({{$internalcontact->ID}})" >{{$internalcontact->FirstName}} {{$internalcontact->LastName}}</a></div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 30px">
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        @if (count($roles) > 0)
                            <table id="roleTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->Name }}</td>
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
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Groups</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        @if (count($permissiongroups) > 0)
                            <table id="pgTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Groups</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissiongroups as $permissiongroup)
                                    <tr>
                                        <td>{{ $permissiongroup->Name }}</td>
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
        </div>

        <div class="row" style="padding-top: 30px">
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 400px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Specific Permissions</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if (count($specificpermissions) > 0)
                            <table id="spTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Groups</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($specificpermissions as $specificpermission)
                                    <tr>
                                        <td>{{ $specificpermission->Description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No specific permission groups assigned to this user</p>
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
                                        <th>Groups</th>
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
                scrollCollapse: true,
                scrollY: '150px'
            });

            $('#pgTable').DataTable({
                paging: false,
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

    
    <script>
        function displayIC(contactID) {
            // Do something with the user ID
            Livewire.dispatch('show-viewic-modal', { id: contactID })
        }

        window.addEventListener('display-viewic-modal', event => {
            $('#viewICModal').modal('show');
        })
    </script>
@endsection