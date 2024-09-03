@extends('layout')

@section('title')
    <title>IPM | Create Employee Contact</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Employee Contact</h1>
        </div>
        
        <form method="POST" id="updateUser" action="{{ route('createic') }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input name="FirstName" type="text" class="form-control" id="floatingInput" placeholder="FirstName" style="color: black" required>
                                <label for="floatingInput" style="color: black">First Name</label>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input name="LastName" type="text" class="form-control" id="floatingInput" placeholder="LastName" style="color: black" required>
                                <label for="floatingInput" style="color: black">Last Name</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <label for="title">Role &nbsp;</label>
                            <select name="MOHRoleId" class="form-select" style="display: inline;width: 300px" required>
                                <option value=""></option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->ID }}">{{ $role->Name }} </option>
                                @endforeach
                
                            </select>
                        </div>

                        <div class="col" style="display: flex">
                            <label style="margin-top: 5px" for="title">Email &nbsp;</label>
                            <input class="form-control" name="Email" type="email" name="" required style="width: 300px">
                        </div>

                        <div class="col" style="display: flex">
                            <label style="margin-top: 5px" for="title">Phone Ext. &nbsp;</label>
                            <input class="form-control" name="PhoneExt" type="text" name="" style="width: 300px">
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px">
                        <div class="col">
                            <label for="title">Department &nbsp;</label>
                            <select name="BusinessGroupId" class="form-select" style="display: inline;width: 400px">
                                <option value=""></option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->ID }}">{{ $department->Name }} </option>
                                @endforeach
                
                            </select>
                        </div>

                    </div>

                </div>

            </div>

          
        <hr class="border border-primary border-3 opacity-35">

        <div class="row" style="padding-top: 10px; padding-bottom:30px;">
            <div class="col">
                
                <button type="submit" href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text"  style="width: 70px">Save</span>
                </button> 

                &nbsp;&nbsp;

                <a href="{{ route('listinternalcontacts')}}" class="btn btn-outline-secondary" style="width: 7rem">Cancel</a>

            </div>
        </div>
    </form>


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
    $(document).ready(function(){
    // Show the collapse on page load
    $("#orgCollapse").collapse('show');
    });
    $(document).ready(function(){
    // Show the collapse on page load
    $("#EmpCollapse").collapse('show');
    });
    document.addEventListener('DOMContentLoaded', function() {
    // Get the paragraph element by its ID
    var activeheader = document.getElementById('mohemployeesheader');
    var activelink = document.getElementById('createiclink');

    // Set the fontWeight property to 'bold'
    activeheader.style.fontWeight = 'bold';
    activelink.style.fontWeight = 'bold';
    activelink.style.textDecoration = 'underline';
    });
</script>
    
@endsection