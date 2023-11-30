@extends('layout')

@section('title')
    <title>IPM | Department Details</title>
@endsection

@section('styles')
@endsection

@section('content')
    

        <!-- Page Heading -->
        <div class="row">
            <div class="col">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Department</h1>
                </div>
            </div>
            <div class="col" style="text-align: end">
                
                <a href="{{ route('editdepartment', ['id' => $department->ID]) }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-user-edit"></i>
                    </span>
                    <span class="text"  style="width: 70px">Edit</span>
                </a> 
                &nbsp;&nbsp;&nbsp;

                <a href="{{ route('listdepartments')}}" class="btn btn-outline-secondary" style="width: 8rem">Return to List</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">Name: {{$department->Name}}</div>
                    <div class="col">Type: {{$department->BGTypeName}}</div>
                    <div class="col">Abbreviation: {{$department->Abbreviation}}</div>
                </div>
                <div class="row" style="padding-top: 20px">
                    <div class="col">Details: {{$department->Details}}</div>
                    <div class="col">Parent Department: @if ($parentdept!== null)
                        {{$parentdept}}
                    @endif</div>
                    <div class="col" >Active: <i class="{{ $department->IsActive == 1 ? 'bi bi-check-lg' : 'bi bi-x-lg' }}"></i></div>
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
            $('#dataTable').DataTable();
        });
        $(document).ready(function(){
        // Show the collapse on page load
        $("#orgCollapse").collapse('show');
        });
        $(document).ready(function(){
        // Show the collapse on page load
        $("#DeptCollapse").collapse('show');
        });
    </script>
@endsection