<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="description" content="">
    <meta name="author" content="">

    @yield('title')

    <!-- Custom fonts for this template-->
    <link href="{{ asset('js/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app.css') }}" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body #toast-container > div {
            opacity: 1;
        }
    </style>
    @livewireStyles
    @yield('styles')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-file-contract fa-lg"></i>
                </div>
                <div class="sidebar-brand-text mx-3">IPM</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UserControlCollapse"
                    aria-expanded="true" aria-controls="UserControlCollapse">
                    <i class="bi bi-person-fill-gear"></i>
                    <span>User Control</span>
                </a>
                <div id="UserControlCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" id="useraccheader" href="#" data-toggle="collapse" 
                        data-target="#UserAccCollapse" aria-expanded="true" aria-controls="UserAccCollapse">User Accounts</a>

                        <div id="UserAccCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#UserControlCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a id="listuserslink" class="collapse-item" href="{{ route('listusers') }}">List Users</a>
                                <a id="createuserlink" class="collapse-item" href="{{ route('newuser') }}">Create User</a>
                            </div>
                        </div>
                        
                        
                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#RolesCollapse" aria-expanded="true" aria-controls="RolesCollapse">Roles</a>

                        <div id="RolesCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#UserControlCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Roles</a>
                                <a class="collapse-item" href="#">Create Roles</a>
                            </div>
                        </div>

                        
                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#PGCollapse" aria-expanded="true" aria-controls="PGCollapse">Permission Groups</a>

                        <div id="PGCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#UserControlCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Perm. Groups</a>
                                <a class="collapse-item" href="#">Create Perm. Groups</a>
                            </div>
                        </div>


                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#PermCollapse" aria-expanded="true" aria-controls="PermCollapse">Permissions</a>

                        <div id="PermCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#UserControlCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Permissions</a>
                                <a class="collapse-item" href="#">Permissions</a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orgCollapse"
                    aria-expanded="true" aria-controls="orgCollapse">
                    <i class="bi bi-building-fill"></i>
                    <span>MOH Organizaiton</span>
                </a>
                <div id="orgCollapse" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="#" data-toggle="collapse" id="deptheader" 
                        data-target="#DeptCollapse" aria-expanded="true" aria-controls="DeptCollapse">Departments</a>

                        <div id="DeptCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#orgCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a id="listdepartmentslink" class="collapse-item" href="{{ route('listdepartments') }}">List Departments</a>
                                <a id="createdepartmentlink" class="collapse-item" href="{{route('newdept')}}">Create Department</a>
                            </div>
                        </div>


                        <a class="collapse-item" href="#" data-toggle="collapse" id="mohpositionsheader"
                        data-target="#PositionCollapse" aria-expanded="true" aria-controls="PositionCollapse">MOH Positions</a>

                        <div id="PositionCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#orgCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a id="listmohroleslink" class="collapse-item" href="{{route('listmohroles')}}">List MOH Roles</a>
                                <a id="createmohroleslink" class="collapse-item" href="#">Create MOH Role</a>
                            </div>
                        </div>


                        <a class="collapse-item" href="#" data-toggle="collapse" id="mohemployeesheader"
                        data-target="#EmpCollapse" aria-expanded="true" aria-controls="EmpCollapse">MOH Employees</a>

                        <div id="EmpCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#orgCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a id="listiclink" class="collapse-item" href="{{ route('listinternalcontacts') }}">List MOH Contacts</a>
                                <a id="createiclink" class="collapse-item" href="{{ route('newinternalcontact') }}">Create MOH Contact</a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#entityCollapse"
                    aria-expanded="true" aria-controls="entityCollapse">
                    <i class="bi bi-person-video2"></i>
                    <span>External Entities</span>
                </a>
                <div id="entityCollapse" class="collapse" aria-labelledby="headingEntities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#CompaniesCollapse" aria-expanded="true" aria-controls="CompaniesCollapse">External Companies</a>

                        <div id="CompaniesCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#entityCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Departments</a>
                                <a class="collapse-item" href="#">Create Department</a>
                            </div>
                        </div>


                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#PersonsCollapse" aria-expanded="true" aria-controls="PersonsCollapse">External Persons</a>

                        <div id="PersonsCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#entityCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Ext. Contacts</a>
                                <a class="collapse-item" href="#">Create Ext. Contact</a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePurchases"
                    aria-expanded="true" aria-controls="collapsePurchases">
                    <i class="bi bi-coin"></i>
                    <span>Purchases</span>
                </a>
                <div id="collapsePurchases" class="collapse" aria-labelledby="headingPurchases" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">List Purchases</a>
                        <a class="collapse-item" href="#">Create Purchases</a>
                    </div>
                </div>
            </li>

            
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#contractsCollapse"
                    aria-expanded="true" aria-controls="contractsCollapse">
                    <i class="bi bi-newspaper"></i>
                    <span>Contracts</span>
                </a>
                <div id="contractsCollapse" class="collapse" aria-labelledby="headingEntities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="#" data-toggle="collapse" 
                        data-target="#ISCollapse" aria-expanded="true" aria-controls="ISCollapse">Items/Services</a>

                        <div id="ISCollapse" class="collapse" aria-labelledby="headingThree" data-parent="#contractsCollapse">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#">List Item Contracts</a>
                                <a class="collapse-item" href="#">Create Item Contract</a>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNoti"
                    aria-expanded="true" aria-controls="collapseNoti">
                    <i class="bi bi-bell-fill"></i>
                    <span>Notifications</span>
                </a>
                <div id="collapseNoti" class="collapse" aria-labelledby="headingNoti" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">List Notifications</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


</body>


    
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('js/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@livewireScripts
@yield('scripts')

</html>