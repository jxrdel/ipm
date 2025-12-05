@extends('layout')

@section('title')
    <title>IPM | Leave Dashboard</title>
@endsection

@section('styles')
    {{-- FullCalendar and Chart.js for modern dashboard elements --}}
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bs-primary-rgb: 78, 115, 223;
            --bs-secondary-rgb: 133, 135, 150;
            --fc-border-color: #e3e6f0;
            --fc-daygrid-event-dot-width: 8px;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: .5rem;
        }

        .breadcrumb-item a {
            color: #858796;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #5a5c69;
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }

        .card-header,
        .card-footer {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .fc {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #5a5c69;
        }

        .fc .fc-button-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            transition: all 0.2s;
        }

        .fc .fc-button-primary:hover {
            background-color: #2e59d9;
            border-color: #2653b4;
        }

        .fc-event {
            border: none !important;
            padding: 4px 8px;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 0.35rem;
        }

        .fc-event-main-frame:hover {
            cursor: pointer;
        }

        .widget-card .card-body {
            display: flex;
            align-items: center;
        }

        .widget-card .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .widget-card .text-xs {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
        }

        .widget-card .h5 {
            font-weight: 700;
        }

        .upcoming-leave-list .leave-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            padding: 0.4rem 0;
            border-bottom: 1px solid #e3e6f0;
        }

        .upcoming-leave-list .leave-item:last-child {
            border-bottom: none;
        }

        .leave-type-badge {
            font-size: 0.7rem;
            padding: 0.25em 0.6em;
        }

        /* Leave Type Colors */
        .leave-sick-leave {
            background-color: rgba(246, 194, 62, 0.2);
            color: #c08000;
        }

        .leave-vacation-leave {
            background-color: rgba(78, 115, 223, 0.2);
            color: #006fba;
        }

        .leave-casual-leave {
            background-color: rgba(146, 199, 61, 0.2);
            color: #92c73d;
        }

        .leave-bereavement-leave {
            background-color: rgba(133, 135, 150, 0.2);
            color: #858796;
        }

        .fc-event.leave-sick-leave {
            background-color: #f6c23e;
            color: #fff;
        }

        .fc-event.leave-vacation-leave {
            background-color: #006fba;
            color: #fff;
        }

        .fc-event.leave-casual-leave {
            background-color: #92c73d;
            color: #fff;
        }

        .fc-event.leave-bereavement-leave {
            background-color: #858796;
            color: #fff;
        }

        .page-title {
            font-weight: 800;
            color: #36454f;
        }
    </style>
@endsection

@section('content')
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="page-title">Leave Management Dashboard</h1>
            <p class="mb-0 text-gray-600">View and manage employee leave across the department.</p>
        </div>
    </div>

    <div class="row mb-3" style="margin-left: 5px">
        <a href="{{ route('leave.create') }}" class="btn btn-primary btn-icon-split" style="width: 12rem">
            <span class="icon text-white-50">
                <i class="fas fa-plus" style="color: white"></i>
            </span>
            <span class="text" style="width: 200px">Add Leave</span>
        </a>
    </div>

    <!-- Widgets Row -->
    <div class="row">
        <!-- Upcoming Leave -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body widget-card">
                    <div class="icon-circle bg-primary text-white"><i class="bi bi-calendar-event fs-5"></i></div>
                    <div class="flex-grow-1">
                        <div class="text-xs text-primary">Upcoming Leave (Next 30 Days)</div>
                        <div class="h5 mb-0">{{ $upcomingLeaves->count() }} Employees</div>
                    </div>
                </div>
                <div class="card-footer py-2 px-3">
                    <div class="upcoming-leave-list">
                        @forelse($upcomingLeaves as $leave)
                            <div class="leave-item">
                                <span>{{ $leave->internalContact->FirstName }}
                                    {{ $leave->internalContact->LastName }}</span>
                                <span>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('M d') }}
                                    <span
                                        class="badge leave-{{ strtolower(str_replace(' ', '-', \App\Enums\LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() ?? '')) }}">{{ \App\Enums\LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() }}</span>
                                </span>
                            </div>
                        @empty
                            <div class="text-center text-muted small p-3">No upcoming leave.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- On Leave Today -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body widget-card">
                    <div class="icon-circle bg-success text-white"><i class="bi bi-person-check-fill fs-5"></i></div>
                    <div class="flex-grow-1">
                        <div class="text-xs text-success">On Leave Today</div>
                        <div class="h5 mb-0">{{ $ongoingLeaves->count() }} Employees</div>
                    </div>
                </div>
                <div class="card-footer py-2 px-3">
                    <div class="upcoming-leave-list">
                        @forelse($ongoingLeaves as $leave)
                            <div class="leave-item">
                                <span>{{ $leave->internalContact->FirstName }} {{ $leave->internalContact->LastName }}
                                    <span class="badge bg-success small">Ongoing
                                        ({{ $leave->days_remaining_from_today }}
                                        {{ Illuminate\Support\Str::plural('day', $leave->days_remaining_from_today) }}
                                        left)</span></span>
                                <span
                                    class="badge leave-{{ strtolower(str_replace(' ', '-', \App\Enums\LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() ?? '')) }}">{{ \App\Enums\LeaveTypeEnum::tryFrom($leave->leave_type)?->getLabel() }}</span>
                            </div>
                        @empty
                            <div class="text-center text-muted small p-3">No employees on leave today.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Summary -->
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body widget-card">
                    <div class="icon-circle bg-info text-white"><i class="bi bi-pie-chart-fill fs-5"></i></div>
                    <div class="flex-grow-1">
                        <div class="text-xs text-info">Leave Summary (This Month)</div>
                        <div class="h5 mb-0">{{ $totalApplicationsMonth }} Applications</div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-around text-center">
                    <div>
                        <div class="small text-muted">Total On Leave</div>
                        <div class="fw-bold">{{ $ongoingLeaves->count() }}</div>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <div class="small text-muted">Most Common</div>
                        <div class="fw-bold">
                            {{ \App\Enums\LeaveTypeEnum::tryFrom($mostCommonLeaveType)?->getLabel() ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Calendar -->
    <div class="row mb-4">
        <div class="col-12">
            <div id='leaveCalendar'></div>
        </div>
    </div>

    <!-- Analytics Section -->
    {{-- <div class="row mt-4">
        <!-- Leave Type Stats -->
        <div class="card h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Leave Type Statistics (Amount of Days Taken this Year)</h6>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height:250px;">
                    <canvas id="leaveBarChart"></canvas>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var activelink = document.getElementById('leavelink');
            var activeicon = document.getElementById('leaveicon');

            // Set the fontWeight property to 'bold'
            activelink.style.color = 'white';
            activelink.style.fontWeight = 'bold';
            activeicon.style.color = 'white';

            // Data from Controller
            const leaveEvents = {!! json_encode($calendarEvents) !!};
            const chartLabels = {{ Js::from($leaveTypeStats->keys()) }};
            const chartData = {{ Js::from($leaveTypeStats->values()) }};

            // Initialize FullCalendar
            var calendarEl = document.getElementById('leaveCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: leaveEvents,
                eventDidMount: function(info) {
                    // Tooltip on hover
                    var tooltip = new bootstrap.Tooltip(info.el, {
                        title: `<strong>${info.event.title}</strong><br>
                        ${info.event.extendedProps.type}<br>
                        ${info.event.start.toLocaleDateString()} - ${info.event.end ? new Date(info.event.end.getTime() - 1).toLocaleDateString() : info.event.start.toLocaleDateString()}`,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body',
                        html: true
                    });
                },
                eventClick: function(info) {
                    window.location.href = "{{ route('leave.view', ['leave' => ':id']) }}".replace(':id', info.event.id);
                },
                height: 650,
                contentHeight: 600,
            });
            calendar.render();

            // Initialize Chart.js Bar Chart
            var ctx = document.getElementById('leaveBarChart').getContext('2d');

            const leaveTypeColors = {
                'Sick Leave': '#f6c23e',
                'Vacation Leave': '#006fba',
                'Casual Leave': '#92c73d',
                'Bereavement Leave': '#858796',
                'Other': '#54a2eb' // Default color for unspecified leave types
            };

            const backgroundColors = chartLabels.map(label => {
                const hex = leaveTypeColors[label] || leaveTypeColors['Other'];
                // Convert hex to rgba for background with transparency
                const r = parseInt(hex.slice(1, 3), 16);
                const g = parseInt(hex.slice(3, 5), 16);
                const b = parseInt(hex.slice(5, 7), 16);
                return `rgba(${r}, ${g}, ${b}, 0.8)`;
            });

            const borderColors = chartLabels.map(label => {
                const hex = leaveTypeColors[label] || leaveTypeColors['Other'];
                return hex; // Use hex directly for border
            });

            var leaveBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Days Taken (YTD)',
                        data: chartData,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
