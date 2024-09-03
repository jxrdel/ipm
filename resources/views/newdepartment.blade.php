@extends('layout')

@section('title')
    <title>IPM | Create Department</title>
@endsection

@section('styles')
@endsection

@section('content')
    
    <form method="POST" id="createdept" action="{{ route('createdept') }}">
        @csrf
        @method('PUT')
        <!-- Page Heading -->
        <div class="row">
            <div class="col">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Department</h1>
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

                <a href="{{ route('listdepartments') }}" class="btn btn-outline-secondary" style="width: 7rem">Cancel</a>
                
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col" style="display: flex"> 
                        <label style="margin-top: 5px" for="">Name: &nbsp;</label>
                        <input class="form-control" type="text" name="Name" value="" style="width: 350px">
                    </div>

                    <div class="col"> 
                        <label for="">Type </label>
                        <select name="BusinessGroupTypeId" class="form-select" style="display: inline;width: 150px">
                                    
                            @foreach ($bgtypes as $bgtype)
                                    <option value="{{ $bgtype->ID }}">{{ $bgtype->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>

                    <div class="col" style="display: flex">
                        <label style="margin-top: 5px" for="">Abbreviation: &nbsp;</label>
                        <input class="form-control" type="text" name="Abbreviation" value="" style="width: 200px">
                    </div>
                </div>

                <div class="row" style="padding-top: 20px">

                    <div class="col-4" style="display: flex">
                        <label style="margin-top: 5px" for="">Details: &nbsp;</label>
                        <input class="form-control" type="text" name="Details" value="" style="width: 200px">
                    </div>
                    
                    <div class="col"> 
                        <label for="">Parent Department: </label>
                        <select name="ParentId" class="form-select" style="display: inline;width: 350px">
                            <option value=""></option>        
                            @foreach ($alldepts as $dept)
                                    <option value="{{ $dept->ID }}">{{ $dept->Name }} </option>
                            @endforeach
            
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

        
        

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
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activeheader = document.getElementById('deptheader');
        var activelink = document.getElementById('createdepartmentlink');

        // Set the fontWeight property to 'bold'
        activeheader.style.fontWeight = 'bold';
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
@endsection