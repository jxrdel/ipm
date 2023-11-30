@extends('layout')

@section('title')
    <title>IPM | Users</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    <a href="{{route('newuser')}}" class="btn btn-primary btn-icon-split" style="width: 10rem">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-plus" style="color: white"></i>
                        </span>
                        <span class="text"  style="width: 200px">Create User</span>
                    </a> 
                </div>
                <div class="row" style="margin-top: 30px">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th style="text-align: center">Active</th>
                                <th style="text-align: center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->Name }}</td>
                                <td style="text-align: center"><i class="{{ $user->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i> </td>
                                <td><a href="{{ route('userdetails', ['id' => $user->ID]) }}">View</a> | <a href="{{ route('edituser', ['id' => $user->ID]) }}">Edit</a> | <a href="#">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            $('#dataTable').DataTable();
        });
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
        var activelink = document.getElementById('listuserslink');

        // Set the fontWeight property to 'bold'
        activeheader.style.fontWeight = 'bold';
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
    
@endsection