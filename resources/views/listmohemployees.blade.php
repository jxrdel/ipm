@extends('layout')

@section('title')
    <title>ICT Contracts | MOH Employees</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @livewire('view-internal-contact-modal')
    @livewire('edit-internal-contact-modal')
    @include('access-denied')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">MOH Employees</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row" style="margin-left: 5px">

                @auth
                    @if (auth()->user()->hasPermission('InternalContact : Create : Screen'))
                        <a href="{{ route('newinternalcontact') }}" class="btn btn-primary btn-icon-split" style="width: 12rem">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text" style="width: 200px">Add Employee</span>
                        </a>
                    @else
                        <button disabled class="btn btn-primary btn-icon-split"
                            style="width: 12rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Access denied">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text" style="width: 200px">Add Employee</span>
                        </button>
                    @endif
                @endauth
            </div>
            <div class="row" style="margin-top: 30px">
                {{-- <livewire:internal-contacts-table/> --}}

                <table id="ictable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="display: none">ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Ext. No</th>
                            <th>Department</th>
                            <th>Role</th>
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
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("{{ Session::get('success') }}", '', {
                timeOut: 3000
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#ictable').DataTable({
                "pageLength": 10,
                // order: [[1, 'asc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getinternalcontacts') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'ID',
                        name: 'ID',
                        "visible": false,
                        searchable: false
                    },
                    {
                        data: 'FirstName',
                        name: 'FirstName'
                    },
                    {
                        data: 'LastName',
                        name: 'LastName'
                    },
                    {
                        data: 'Email',
                        name: 'Email'
                    },
                    {
                        data: 'PhoneExt',
                        name: 'PhoneExt'
                    },
                    {
                        data: 'DepartmentName',
                        name: 'BusinessGroups.Name'
                    },
                    {
                        data: 'RoleName',
                        name: 'MOHRoles.Name'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="#" onclick="showView(' + data.ID +
                                ')">View</a> | <a href="#" onclick="showEdit(' + data.ID +
                                ')">Edit</a> | <a href="#" onclick="showDelete(' + data.ID +
                                ')">Delete</a>';
                        }
                    },
                ]
            });
        });


        window.addEventListener('refresh-table', event => {
            $('#ictable').DataTable().ajax.reload();
        })

        function showView(id) {
            Livewire.dispatch('show-viewic-modal', {
                id: id
            });
        }

        function showEdit(id) {
            var hasPermission = "{{ auth()->user()->hasPermission('InternalContact : Edit : Screen') ?? '' }}";
            if (hasPermission == 1) {
                Livewire.dispatch('show-editic-modal', {
                    id: id
                });
            } else {
                $('#deniedModal').modal('show');
            }
        }

        function showDelete(id) {
            var hasPermission = "{{ auth()->user()->hasPermission('InternalContact : Delete : Screen') ?? '' }}";
            if (hasPermission == 1) {
                // Display a confirmation dialog
                var deleteConfirmation = confirm('Are you sure you want to delete this user?');

                // Check the user's choice
                if (deleteConfirmation) {
                    // User clicked OK
                    Livewire.dispatch('delete-user', {
                        id: id
                    });
                }
            } else {
                $('#deniedModal').modal('show');
            }
        }

        $(document).ready(function() {
            // Show the collapse on page load
            $("#orgCollapse").collapse('show');
        });
        $(document).ready(function() {
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
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("Contact edited successfully", '', {
                timeOut: 3000
            });
        })

        window.addEventListener('show-delete-success', event => {

            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("Contact deleted successfully", '', {
                timeOut: 3000
            });
        })
    </script>
@endsection
