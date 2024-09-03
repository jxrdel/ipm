@extends('layout')

@section('title')
    <title>IPM | Notifications</title>
@endsection

@section('styles')
    <link href="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    
        @livewire('view-notification-modal')
        @include('access-denied')
        {{-- @livewire('edit-notification-modal') --}}
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
        </div>

        <div class="card">
            <div class="card-body">
                
                <div class="row" style="margin-top: 30px">
                    
                    <table id="notitable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Item</th>
                                <th>Label</th>
                                <th>Action</th>
                                <th>Display Date</th>
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
            $('#notitable').DataTable({
                "pageLength": 10,
                order: [[4, 'asc']],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('getnotifications') }}", 
                    "type": "GET"
                },
                "columns": [
                        { data: 'ItemController', name: 'ItemController' },
                        { data: 'ItemName', name: 'ItemName' },
                        { data: 'Label', name: 'Label' },
                        { data: 'ItemAction', name: 'ItemAction' },
                        {
                            data: 'DisplayDate',
                            name: 'DisplayDate',
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

        
        window.addEventListener('refresh-table', event => {
            $('#notitable').DataTable().ajax.reload();
        })
        
        function showView(id) {
            Livewire.dispatch('show-noti-modal', { id: id });
        }
        
        function showEdit(id) {
            var hasPermission = "{{auth()->user()->hasPermission('NotificationItem : Edit : Screen') ?? ''}}";
            if (hasPermission == 1){
                $('#deniedModal').modal('show');
            } else {
                $('#deniedModal').modal('show');
            }
        }

        function showDelete(id) {
            var hasPermission = "{{auth()->user()->hasPermission('NotificationItem : Delete : Screen') ?? ''}}";
            if (hasPermission == 1){
                $('#deniedModal').modal('show');
            } else {
                $('#deniedModal').modal('show');
            }
        }

        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the paragraph element by its ID
        var activelink = document.getElementById('notilink');
        var activeicon = document.getElementById('notificationicon');

        // Set the fontWeight property to 'bold'
        activelink.style.color = 'white';
        activelink.style.fontWeight = 'bold';
        activeicon.style.color = 'white';
        });
    </script>
    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createModal').modal('hide');
        })

        window.addEventListener('display-noti-modal', event => {
            $('#viewNotiModal').modal('show');
        })

        window.addEventListener('display-editep-modal', event => {
            $('#editEPModal').modal('show');
        })

        window.addEventListener('close-edit-modal', event => {
            $('#editEPModal').modal('hide');
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