@extends('layout')

@section('title')
    <title>IPM | Purchases</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    
        @livewire('create-purchase-modal')
        @livewire('view-purchase-modal')
        @livewire('edit-purchase-modal')
        @include('access-denied')
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Purchases</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    
                @auth
                    @if (auth()->user()->hasPermission('ExternalPurchase : Create : Screen'))
                        <a type="button" data-bs-toggle="modal" data-bs-target="#createPurchaseModal" class="btn btn-primary btn-icon-split" style="width: 12rem">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text"  style="width: 200px">Add Purchase</span>
                        </a> 
                    @else
                        <button disabled class="btn btn-primary btn-icon-split" style="width: 12rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Access denied">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text"  style="width: 200px">Add Purchase</span>
                        </button>
                    @endif
                @endauth
                </div>
                <div class="row" style="margin-top: 30px">
                    {{-- <livewire:purchases-table/> --}}

                    <table id="purchasetable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Purchase Type</th>
                                <th style="text-align: center">Active</th>
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
            $('#purchasetable').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getpurchases') }}", 
                    "type": "GET"
                },
                "columns": [
                        { data: 'Name', name: 'Name' },
                        { data: 'CompanyName', name: 'ExternalContactCompanies.CompanyName' },
                        { data: 'PTypeName', name: 'ExternalPurchaseTypes.Name' },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                if(data.IsActive == 1){
                                    return '<div style="display:flex; justify-content: center; align-items: center;"><i class="bi bi-check-lg"></i></div>';
                                }else{
                                    return '<i class="fas fa-times"></i>';
                                }
                            }
                        },
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
            $('#purchasetable').DataTable().ajax.reload();
        })
        
        function showView(id) {
            Livewire.dispatch('show-viewpurchase-modal', { id: id });
        }
        
        function showEdit(id) {
            var hasPermission = "{{auth()->user()->hasPermission('ExternalPurchase : Edit : Screen') ?? ''}}";
            if (hasPermission == 1){
                Livewire.dispatch('show-editpurchase-modal', { id: id });
            } else {
                $('#deniedModal').modal('show');
            }
        }

        function showDelete(id) {
            var hasPermission = "{{auth()->user()->hasPermission('ExternalPurchase : Delete : Screen') ?? ''}}";
            if (hasPermission == 1){
                $('#deniedModal').modal('show');
            } else {
                $('#deniedModal').modal('show');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activelink = document.getElementById('purchaselink');
        var activeicon = document.getElementById('purchaseicon');

        // Set the fontWeight property to 'bold'
        activelink.style.color = 'white';
        activelink.style.fontWeight = 'bold';
        activeicon.style.color = 'white';
        });
    </script>
    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createPurchaseModal').modal('hide');
        })

        window.addEventListener('display-viewpurchase-modal', event => {
            $('#viewPurchaseModal').modal('show');
        })

        window.addEventListener('display-editpurchase-modal', event => {
            $('#editPurchaseModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editPurchaseModal').modal('hide');
        })

        window.addEventListener('show-create-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Purchase added successfully",'' , {timeOut:3000});
        })

        window.addEventListener('show-edit-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Purchase edited successfully",'' , {timeOut:3000});
        })
    </script>
    
@endsection