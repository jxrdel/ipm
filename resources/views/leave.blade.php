@extends('layout')

@section('title')
    <title>IPM | Leave Management</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('access-denied')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leave Management</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row" style="margin-left: 5px">
                <a href="{{ route('leave.create') }}" class="btn btn-primary btn-icon-split" style="width: 12rem">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus" style="color: white"></i>
                    </span>
                    <span class="text" style="width: 200px">Add Leave</span>
                </a>
            </div>
            <div class="row" style="margin-top: 15px; margin-left: 5px">
                <div class="col-10"></div>
                <div class="col" style="text-align:right">
                    <div class="btn-group" role="group" aria-label="Leave filter button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btn-upcoming" autocomplete="off"
                            checked>
                        <label class="btn btn-outline-primary" for="btn-upcoming">Upcoming</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-all" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btn-all">All</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btn-ongoing" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btn-ongoing">Ongoing</label>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 30px">
                <table id="leavetable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Internal Contact</th>
                            <th>Days Taken</th>
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
            var table = $('#leavetable').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getupcomingleaves') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'leave_type_label',
                        name: 'leave_type_label',
                        searchable: true
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'internal_contact_name',
                        name: 'internal_contact_name',
                        searchable: true
                    },
                    {
                        data: 'days_to_be_taken',
                        name: 'days_to_be_taken'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="#" onclick="showView(' + data.id +
                                ')">View</a> | <a href="#" onclick="showEdit(' + data.id +
                                ')">Edit</a> | <a href="#" onclick="showDelete(' + data.id +
                                ')">Delete</a>';
                        }
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('.btn-check').change(function() {
                var selectedOption = $("input[name='btnradio']:checked").attr('id');
                var newUrl;
                switch (selectedOption) {
                    case 'btn-upcoming':
                        newUrl = '{{ route('getupcomingleaves') }}';
                        break;
                    case 'btn-all':
                        newUrl = '{{ route('getleaves') }}';
                        break;
                    case 'btn-ongoing':
                        newUrl = '{{ route('getongoingleaves') }}';
                        break;
                }
                table.ajax.url(newUrl).load();
            });
        });


        window.addEventListener('refresh-table', event => {
            $('#leavetable').DataTable().ajax.reload();
        })

        // Removed Livewire modal functions related to purchases, these will be added when requested for leaves.
        // function showView(id) {
        //     Livewire.dispatch('show-viewleave-modal', { id: id });
        // }

        // function showEdit(id) {
        //     var hasPermission = "{{ auth()->user()->hasPermission('Leave : Edit : Screen') ?? '' }}";
        //     if (hasPermission == 1){
        //         Livewire.dispatch('show-editleave-modal', { id: id });
        //     } else {
        //         $('#deniedModal').modal('show');
        //     }
        // }

        // function showDelete(id) {
        //     var hasPermission = "{{ auth()->user()->hasPermission('Leave : Delete : Screen') ?? '' }}";
        //     if (hasPermission == 1){
        //         $('#deniedModal').modal('show');
        //     } else {
        //         $('#deniedModal').modal('show');
        //     }
        // }

        document.addEventListener('DOMContentLoaded', function() {
            // Get the paragraph element by its ID
            var activelink = document.getElementById('leavelink');
            var activeicon = document.getElementById('leaveicon');

            // Set the fontWeight property to 'bold'
            if (activelink) activelink.style.color = 'white';
            if (activelink) activelink.style.fontWeight = 'bold';
            if (activeicon) activeicon.style.color = 'white';
        });
    </script>
    {{-- Removed Livewire modal event listeners related to purchases, these will be added when requested for leaves. --}}
@endsection
