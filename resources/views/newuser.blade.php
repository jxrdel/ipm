@extends('layout')

@section('title')
    <title>IPM | Create User</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    
    <form action="{{ route('createuser') }}" method="post">
        @csrf
        @method('PUT')
        <!-- Page Heading -->
        <div class="row">
            <div class="col">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Create User</h1>
                </div>
            </div>
            <div class="col" style="text-align: end">
                
                <button type="#" href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text"  style="width: 70px">Save</span>
                </button> 
                &nbsp;&nbsp;&nbsp;

                <a href="{{ route('listusers') }}" class="btn btn-outline-secondary" style="width: 7rem">Cancel</a>
                
            </div>
        </div>

        <div class="row">
            <div class="col">
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4" style="display: flex">
                                <label style="margin-top: 5px" for="username">User Name: &nbsp;</label>
                                <input class="form-control" name="username" type="text" name="" style="width: 60%" required autocomplete="off">
                            </div>

                            <div class="col-2">
                                <label for="IsActive">Active:&nbsp;</label>
                                <input class="form-check-input" type="checkbox" name="IsActive" style="margin-left: 15px" checked>

                            </div>
                            
                            <div class="col">
                                <div style="margin-top: -6px;display:flex">
                                    <label style="margin-top: 5px" for="title">Internal Contact &nbsp;</label>
                                    <select name="InternalContactId" class="form-select" style="display: inline;width: 300px">
                                        <option value=""></option>
                                                
                                        @foreach ($internalcontacts as $internalcontact)
                                                <option value="{{ $internalcontact->ID }}">{{ $internalcontact->FirstName }} {{ $internalcontact->LastName }}</option>
                                        @endforeach
                        
                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                    <p>No Internal Contact? <a href="{{ route('newinternalcontact') }}">Click Here</a></p>
                                </div>
                            </div>
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
                    @livewire('role-list')
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 20px">
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 300px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Permission Groups</h6>
                    </div>
                    <!-- Card Body -->
                    @livewire('add-permission-groups')
                </div>
            </div>
            <div class="col">
                <div class="card shadow mb-4" style="min-height: 300px">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Permissions</h6>
                    </div>
                    <!-- Card Body -->
                    @livewire('add-permissions')
                </div>
            </div>
        </div>
        


@endsection

@section('scripts')

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
    var activelink = document.getElementById('createuserlink');

    // Set the fontWeight property to 'bold'
    activeheader.style.fontWeight = 'bold';
    activelink.style.fontWeight = 'bold';
    activelink.style.textDecoration = 'underline';
    });
</script>
    
@endsection