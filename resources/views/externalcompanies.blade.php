@extends('layout')

@section('title')
    <title>IPM | External Companies</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    
        @livewire('create-external-company-modal')
        @livewire('view-external-company-modal')
        @livewire('edit-external-company-modal')
        @include('access-denied')
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">External Companies</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    
                @auth
                    @if (auth()->user()->hasPermission('ExternalContactCompany : Create : Screen'))
                        <a type="button" data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary btn-icon-split" style="width: 12rem">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text"  style="width: 200px">Add Company</span>
                        </a> 
                        
                    @else
                        <button disabled class="btn btn-primary btn-icon-split" style="width: 12rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Access denied">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text"  style="width: 200px">Add Company</span>
                        </button>
                    @endif
                @endauth
                </div>
                <div class="row" style="margin-top: 30px">
                    
                    <table id="ectable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Ext. No</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
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
            $('#ectable').DataTable({
                "pageLength": 10,
                // order: [[1, 'asc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getexternalcompanies') }}", 
                    "type": "GET"
                },
                "columns": [
                        { data: 'CompanyName', name: 'CompanyName' },
                        { data: 'AddressLine1', name: 'AddressLine1' },
                        { data: 'Phone1', name: 'Phone1' },
                        { data: 'Email', name: 'Email' },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                return '<a href="#" onclick="showView(' + data.ID + ')">View</a> | <a href="#" onclick="showEdit(' + data.ID + ')">Edit</a> | <a href="#" onclick="showDelete(' + data.ID + ')">Delete</a>';
                            }
                        },
                ]
            });
        });

        
        window.addEventListener('refresh-table', event => {
            $('#ectable').DataTable().ajax.reload();
        })
        
        function showView(id) {
            Livewire.dispatch('show-viewec-modal', { id: id });
        }
        
        function showEdit(id) {
            var hasPermission = "{{auth()->user()->hasPermission('ExternalContactCompany : Edit : Screen') ?? ''}}";
            if (hasPermission == 1){
                Livewire.dispatch('show-editec-modal', { id: id });
            } else {
                $('#deniedModal').modal('show');
            }
        }
        
        function showDelete(id) {
            var hasPermission = "{{auth()->user()->hasPermission('ExternalContactCompany : Delete : Screen') ?? ''}}";
            if (hasPermission == 1){
                $('#deniedModal').modal('show');
            } else {
                $('#deniedModal').modal('show');
            }
        }

        $(document).ready(function(){
        // Show the collapse on page load
        $("#entityCollapse").collapse('show');
        });
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activelink = document.getElementById('eclink');

        // Set the fontWeight property to 'bold'
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createModal').modal('hide');
        })

        window.addEventListener('display-viewec-modal', event => {
            $('#viewECModal').modal('show');
        })

        window.addEventListener('display-editec-modal', event => {
            $('#editECModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editECModal').modal('hide');
        })

        window.addEventListener('show-create-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Company added successfully",'' , {timeOut:3000});
        })

        window.addEventListener('show-edit-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Company edited successfully",'' , {timeOut:3000});
        })
    </script>
    
@endsection