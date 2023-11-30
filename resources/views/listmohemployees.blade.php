@extends('layout')

@section('title')
    <title>IPM | MOH Employees</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    
        @livewire('view-internal-contact-modal')
        @livewire('edit-internal-contact-modal')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">MOH Employees</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    <a href="{{route('newinternalcontact')}}" class="btn btn-primary btn-icon-split" style="width: 12rem">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus" style="color: white"></i>
                        </span>
                        <span class="text"  style="width: 200px">Add Employee</span>
                    </a> 
                </div>
                <div class="row" style="margin-top: 30px">
                    <livewire:internal-contacts-table/>
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
        $("#orgCollapse").collapse('show');
        });
        $(document).ready(function(){
        // Show the collapse on page load
        $("#EmpCollapse").collapse('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activeheader = document.getElementById('mohemployeesheader');
        var activelink = document.getElementById('listiclink');

        // Set the fontWeight property to 'bold'
        activeheader.style.fontWeight = 'bold';
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
    <script>
        window.addEventListener('display-viewic-modal', event => {
            $('#viewICModal').modal('show');
        })
        
        window.addEventListener('display-editic-modal', event => {
            $('#editICModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editICModal').modal('hide');
        })

        window.addEventListener('show-edit-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Role edited successfully",'' , {timeOut:3000});
        })
    </script>
    
@endsection