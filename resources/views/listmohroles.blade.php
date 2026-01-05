@extends('layout')

@section('title')
    <title>ICT Contracts | MOH Roles</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @livewire('edit-role-modal')
    @livewire('create-role-modal')
    @include('access-denied')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">MOH Roles</h1>
    </div>

    <div class="card">
        <div class="card-body">
            @auth
                @if (auth()->user()->hasPermission('MOHRole : Create : Screen'))
                    <a type="button" data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary btn-icon-split"
                        style="width: 9rem">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus" style="color: white"></i>
                        </span>
                        <span class="text" style="width: 200px">Add Role</span>
                    </a>
                @else
                    <button disabled class="btn btn-primary btn-icon-split"
                        style="width: 9rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Access denied">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus" style="color: white"></i>
                        </span>
                        <span class="text" style="width: 200px">Add Role</span>
                    </button>
                @endif
            @endauth


            <div class="row" style="margin-top: 30px">

                <table id="rolestable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
            $('#rolestable').DataTable({
                "pageLength": 10,
                // order: [[1, 'asc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getroles') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="#" onclick="showEdit(' + data.ID + ')">Edit</a>';
                        }
                    },
                ]
            });
        });


        window.addEventListener('refresh-table', event => {
            $('#rolestable').DataTable().ajax.reload();
        })

        $(document).ready(function() {
            // Show the collapse on page load
            $("#orgCollapse").collapse('show');
        });
        $(document).ready(function() {
            // Show the collapse on page load
            $("#PositionCollapse").collapse('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Get the paragraph element by its ID
            var activeheader = document.getElementById('mohpositionsheader');
            var activelink = document.getElementById('listmohroleslink');

            // Set the fontWeight property to 'bold'
            activeheader.style.fontWeight = 'bold';
            activelink.style.fontWeight = 'bold';
            activelink.style.textDecoration = 'underline';
        });
    </script>


    <script>
        function showEdit(roleid) {
            var hasPermission = "{{ auth()->user()->hasPermission('MOHRole : Edit : Screen') ?? '' }}";
            if (hasPermission == 1) {
                Livewire.dispatch('show-edit-modal', {
                    roleid: roleid
                });
            } else {
                $('#deniedModal').modal('show');
            }
        }

        window.addEventListener('show-create-success', event => {

            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("Role added successfully", '', {
                timeOut: 3000
            });
        })

        window.addEventListener('show-edit-success', event => {

            toastr.options = {
                "progressBar": true,
                "closeButton": true,
            }
            toastr.success("Role edited successfully", '', {
                timeOut: 3000
            });
        })

        window.addEventListener('close-create-modal', event => {
            $('#createModal').modal('hide');
        })

        window.addEventListener('display-edit-modal', event => {
            $('#editModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editModal').modal('hide');
        })
    </script>

    <script></script>
@endsection
