@extends('layout')

@section('title')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>IPM | Employee Contracts</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    
        @livewire('create-employee-contract-modal')
        @livewire('edit-employee-contract-modal')
        @livewire('view-employee-contract-modal')
        @include('access-denied')
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Employee Contracts</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-left: 5px">
                    <div class="col-10">
                        @auth
                            @if (auth()->user()->hasPermission('PurchaseContract : Create : Screen'))
                                <a type="button" data-bs-toggle="modal" data-bs-target="#createPCModal" class="btn btn-primary btn-icon-split" style="width: 12rem">
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

                    <div class="col" style="justify-content: end">
                        <button type="button" class="btn btn-primary" id="all-btn">All</button>
                        <button type="button" class="btn btn-success" id="active-btn">Active</button>
                        <button type="button" class="btn btn-warning" id="inactive-btn" style="color: black">Inactive</button>
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
                    "url": "{{ route('getactiveemployeecontracts') }}", 
                    "type": "GET"
                },
                "columns": [
                        { data: 'EmployeeName', name: 'EmployeeName' },
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
                                return '<a href="#" onclick="showView(' + data.ID + ')">View</a> | <a href="#" onclick="showEdit(' + data.ID + ')">Edit</a> | <a href="#" onclick="showDelete(' + data.ID + ')">Delete</a>';
                            }
                        },
                ]
            });
        });


        $('#active-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getactiveemployeecontracts") }}').load();
        });

        $('#inactive-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getinactiveemployeecontracts") }}').load();
        });

        $('#all-btn').on('click', function() {
            $('#contracttable').DataTable().ajax.url('{{ route("getemployeecontracts") }}').load();
        });

        
        window.addEventListener('refresh-table', event => {
            $('#contracttable').DataTable().ajax.reload();
        })
        
        function showView(id) {
            Livewire.dispatch('show-viewec-modal', { id: id });
        }
        
        function showEdit(id) {
            var hasPermission = "{{auth()->user()->hasPermission('PurchaseContract : Edit : Screen') ?? ''}}";
            if (hasPermission == 1){
                Livewire.dispatch('show-editec-modal', { id: id });
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

        $(document).ready(function(){
        // Show the collapse on page load
        $("#contractCollapse").collapse('show');
        });
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activelink = document.getElementById('econtractlink');

        // Set the fontWeight property to 'bold'
        activelink.style.fontWeight = 'bold';
        activelink.style.textDecoration = 'underline';
        });
    </script>
    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createPCModal').modal('hide');
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
            toastr.success("Purchase added successfully",'' , {timeOut:3000});
        })

        window.addEventListener('show-edit-success', event => {
            
            toastr.options = {
                "progressBar" : true,
                "closeButton" : true,
            }
            toastr.success("Contract edited successfully",'' , {timeOut:3000});
        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            new MultiSelectTag('contractdepartments', {
                onChange: function(values) {
                    console.log(values)
                    Livewire.dispatch('set-contractdepartments', { values: values })
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

        var endDateInput = document.getElementById('enddate');
        var startDateLabel = document.getElementById('notistartdate');
        var monthsBeforeInput = document.getElementById('monthsbefore');

        endDateInput.addEventListener('input', function () {
            // Get the selected date value
            var selectedDate = endDateInput.value;
            var monthsBefore = monthsBeforeInput.value;

            // Calculate one month before the selected date
            var oneMonthBefore = new Date(selectedDate);
            oneMonthBefore.setMonth(oneMonthBefore.getMonth() - parseInt(monthsBefore));
            oneMonthBefore.setDate(oneMonthBefore.getDate() + 1);

            startDateLabel.innerHTML = '<i class="far fa-bell"></i>  Start Date: ' + oneMonthBefore.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        });

        
        //Changes start date when user enters how many months before
        monthsBeforeInput.addEventListener('input', function () {
            var selectedDate = new Date(endDateInput.value);
            var monthsBefore = monthsBeforeInput.value;

            var monthsBeforeDate = new Date(selectedDate);
            monthsBeforeDate.setMonth(monthsBeforeDate.getMonth() - parseInt(monthsBefore));
            monthsBeforeDate.setDate(monthsBeforeDate.getDate() + 1);
            startDateLabel.innerHTML = '<i class="far fa-bell"></i>  Start Date: ' + monthsBeforeDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });


        });
        
        </script>
    
@endsection