@extends('layout')

@section('title')
    <title>ICT Contracts | Departments</title>
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

                @auth
                    @if (auth()->user()->hasPermission('BusinessGroup : Create : Screen'))
                        <a href="{{ route('newdept') }}" class="btn btn-primary btn-icon-split" style="width: 12rem">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text" style="width: 200px">Add Department</span>
                        </a>
                    @else
                        <button disabled class="btn btn-primary btn-icon-split"
                            style="width: 12rem;pointer-events: auto;cursor: not-allowed;" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Access denied">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus" style="color: white"></i>
                            </span>
                            <span class="text" style="width: 200px">Add Department</span>
                        </button>
                    @endif
                @endauth
            </div>
            <div class="row" style="margin-top: 30px">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th style="text-align: center">Abbreviation</th>
                            <th style="text-align: center">Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->Name }}</td>
                                <td style="text-align: center">{{ $department->Abbreviation }}</td>
                                <td style="text-align: center">{{ $department->BGTypeName }}</td>
                                <td>
                                    <a href="{{ route('departmentdetails', ['id' => $department->ID]) }}">View</a>

                                    @if (auth()->user()->hasPermission('BusinessGroup : Edit : Screen'))
                                        | <a href="{{ route('editdepartment', ['id' => $department->ID]) }}">Edit</a>
                                    @endif
                                    @if (auth()->user()->hasPermission('BusinessGroup : Delete : Screen'))
                                        | <a href="#">Delete</a>
                                    @endif

                                </td>
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
            $('#dataTable').DataTable();
        });
        $(document).ready(function() {
            // Show the collapse on page load
            $("#orgCollapse").collapse('show');
        });
        $(document).ready(function() {
            // Show the collapse on page load
            $("#DeptCollapse").collapse('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Get the paragraph element by its ID
            var activeheader = document.getElementById('deptheader');
            var activelink = document.getElementById('listdepartmentslink');

            // Set the fontWeight property to 'bold'
            activeheader.style.fontWeight = 'bold';
            activelink.style.fontWeight = 'bold';
            activelink.style.textDecoration = 'underline';
        });
    </script>
@endsection
