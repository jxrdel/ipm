@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>IPM | Purchase Contracts</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    
        @livewire('create-purchase-contract-modal')
        @livewire('edit-purchase-contract-modal')
        @livewire('view-purchase-contract-modal')
        @include('access-denied')
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Purchase Contracts</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    <div class="col">
                        @auth
                            @if (auth()->user()->hasPermission('PurchaseContract : Create : Screen'))
                                <a href="{{route('purchasecontracts.create')}}" class="btn btn-primary btn-icon-split" style="width: 12rem">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus" style="color: white"></i>
                                    </span>
                                    <span class="text"  style="width: 200px">Add Contract</span>
                                </a>
                            @else
                                <button disabled class="btn btn-primary btn-icon-split" style="width: 12rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Access denied">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus" style="color: white"></i>
                                    </span>
                                    <span class="text"  style="width: 200px">Add Contract</span>
                                </button>
                            @endif
                        @endauth 
                    </div>

                    <div class="col" style="text-align:right">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    
                            <input type="radio" class="btn-check" name="btnradio" id="btn-active" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btn-active">Active</label>
                          
                            <input type="radio" class="btn-check" name="btnradio" id="btn-all" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btn-all">All</label>
                          
                            <input type="radio" class="btn-check" name="btnradio" id="btn-inactive" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btn-inactive">Inactive</label>
                          
                        </div>

                    </div>
                </div>
                <div class="row" style="margin-top: 30px">
                    <table id="contracttable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>File Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
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
            $('#contracttable').DataTable({
                "pageLength": 10,
                order: [[3, 'asc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getactivepurchasecontracts') }}", 
                    "type": "GET"
                },
                "columns": [
                        { data: 'Name', name: 'Name' },
                        { data: 'FileNumber', name: 'FileNumber' },
                        {
                            data: 'StartDate',
                            name: 'StartDate',
                            render: function (data, type, row) {
                                if (data) {
                                    var date = new Date(data);
                                    var day = ("0" + date.getDate()).slice(-2);
                                    var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                    var year = date.getFullYear();
                                    return day + "/" + month + "/" + year;
                                }
                                return data;
                            }
                        },
                        {
                            data: 'EndDate',
                            name: 'EndDate',
                            render: function (data, type, row) {
                                if (data) {
                                    var date = new Date(data);
                                    var day = ("0" + date.getDate()).slice(-2);
                                    var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                    var year = date.getFullYear();
                                    return day + "/" + month + "/" + year;
                                }
                                return data;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                return '<a href="#" onclick="showView(' + data.ID + ')">View</a> | <a href="PurchaseContracts/Edit/' + data.ID + '" >Edit</a> | <a href="#" onclick="showDelete(' + data.ID + ')">Delete</a>';
                            }
                        },
                ]
            });
        });

                

        $('#active-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getactivepurchasecontracts") }}').load();
        });

        $('#inactive-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getinactivepurchasecontracts") }}').load();
        });

        $('#all-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getpurchasecontracts") }}').load();
        });

        
        window.addEventListener('refresh-table', event => {
            $('#contracttable').DataTable().ajax.reload();
        })
        
        function showView(id) {
            Livewire.dispatch('show-viewpc-modal', { id: id });
        }
        
        function showEdit(id) {
            var hasPermission = "{{auth()->user()->hasPermission('PurchaseContract : Edit : Screen') ?? ''}}";
            if (hasPermission == 1){
                Livewire.dispatch('show-editpc-modal', { id: id });
            } else {
                $('#deniedModal').modal('show');
            }
        }

        function showDelete(id) {
            var hasPermission = "{{auth()->user()->hasPermission('PurchaseContract : Delete : Screen') ?? ''}}";
            if (hasPermission == 1){
                $('#deniedModal').modal('show');
            } else {
                $('#deniedModal').modal('show');
            }
        }
        
        $('.btn-check').change(function() { //Table Filter
            var selectedOption = $("input[name='btnradio']:checked").attr('id');
            switch(selectedOption) {
                case 'btn-active':
                    $('#contracttable').DataTable().ajax.url('{{ route("getactivepurchasecontracts") }}').load();
                    break;
                case 'btn-inactive':
                    $('#contracttable').DataTable().ajax.url('{{ route("getinactivepurchasecontracts") }}').load();
                    break;
                case 'btn-all':
                    $('#contracttable').DataTable().ajax.url('{{ route("getpurchasecontracts") }}').load();
                    break;
            }
        });

        $(document).ready(function(){
        // Show the collapse on page load
        $("#contractCollapse").collapse('show');
        });
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activelink = document.getElementById('pcontractlink');

        // Set the fontWeight property to 'bold'
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createPCModal').modal('hide');
        })

        window.addEventListener('display-viewpc-modal', event => {
            $('#viewPCModal').modal('show');
        })

        window.addEventListener('display-editpc-modal', event => {
            $('#editPCModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editPCModal').modal('hide');
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
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            new MultiSelectTag('internalcontacts', {
                onChange: function(values) {
                    console.log(values)
                    Livewire.dispatch('set-internalcontacts', { values: values })
                }
            })  // id

            new MultiSelectTag('notifications', {
                onChange: function(values) {
                    console.log(values)
                    Livewire.dispatch('set-notifications', { values: values })
                }
            })  // id

            $(document).ready(function() {
                $('#editinternalcontacts').select2();
            });

            
            window.addEventListener('clear-ic-select', event => {
                $('#editinternalcontacts').val(null).trigger('change');
            })

            window.addEventListener('show-alert', event => {
                var message = event.detail.message;

                // Display an alert with the received message
                alert(message);
            })

            // Listen for the Livewire event 'alertEvent'
            // Livewire.on('show-alert', (message) => {
            //     // Display an alert with the received message
            //     alert('Hello' + event.detail.message);
            // });

            // new MultiSelectTag('editnotifications', {
            //     onChange: function(values) {
            //         console.log(values)
            //     }
            // })  // id
            
        $(document).ready(function () {
            var endDate = $('#enddate');
            endDate.prop('disabled', true);
            
            $('#hidden-row').hide();
            
            $('input[name="options-outlined"]').change(function () {
            // Check which radio button is selected
            if ($('#perpetualradio').is(':checked')) {
                // Show the row if "Show Row" is selected
                $('#hidden-row').hide();
                endDate.val('');
                endDate.prop('disabled', true);
            } else {
                // Hide the row if "Hide Row" is selected
                $('#hidden-row').show();
                Livewire.dispatch('reset-enddate')
                endDate.prop('disabled', false);
            }
            });
        });

        
        window.addEventListener('hide-items', event => {
            $('#hidden-row-edit').hide();
            var endDate = $('#enddateedit');
            endDate.prop('disabled', true);
        })
        
        </script>
    
@endsection