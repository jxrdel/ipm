@extends('layout')

@section('title')
    <title>IPM | Contracts Dashboard</title>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Nunito', sans-serif;
        }

        /* Page Header */
        .page-title {
            font-weight: 800;
            color: #36454f;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: #6c7785;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 1rem;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            transition: 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 0;
            padding-bottom: 0;
        }

        /* Widget Metric Cards */
        .metric-card .metric-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #36454f;
        }

        .metric-card .metric-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6c7785;
            letter-spacing: 0.5px;
        }

        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
        }

        /* Badges */
        .badge-soft {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-danger-soft {
            background: #fde3e3;
            color: #d9534f;
        }

        .badge-warning-soft {
            background: #fff4d6;
            color: #f0ad4e;
        }

        .badge-success-soft {
            background: #dbf6e9;
            color: #28a745;
        }

        /* Table */
        .table thead {
            background: #f2f4f8;
        }

        .table th {
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c7785;
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .status-urgent {
            background: #fde2e0;
            color: #d9534f;
        }

        .status-nearing {
            background: #fff2cd;
            color: #f0ad4e;
        }

        .status-far-out {
            background: #dcf5ea;
            color: #1cc88a;
        }
    </style>
@endsection

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Contracts Dashboard</h1>
            <p class="page-subtitle">Overview of employee and purchase contracts ending this year.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active">Contracts</li>
            </ol>
        </nav>
    </div>


    <!-- Metric Widgets -->
    <div class="row g-4">

        <!-- 4 Month Warning -->
        <div class="col-xl-4 col-md-6">
            <div class="card metric-card p-3 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <div class="metric-label">Ending in 4 Months</div>
                    <div class="metric-value">{{ $contractsEndingSoon }}</div>
                </div>
                <div class="icon-box bg-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
        </div>

        <!-- Employee Contracts -->
        <div class="col-xl-2 col-md-6">
            <div class="card metric-card p-3 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <div class="metric-label">Employee</div>
                    <div class="metric-value">{{ $employeeContractsEndingThisYear }}</div>
                </div>
                <div class="icon-box bg-success"><i class="bi bi-person-fill"></i></div>
            </div>
        </div>

        <!-- Purchase Contracts -->
        <div class="col-xl-2 col-md-6">
            <div class="card metric-card p-3 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <div class="metric-label">Purchase</div>
                    <div class="metric-value">{{ $purchaseContractsEndingThisYear }}</div>
                </div>
                <div class="icon-box bg-primary"><i class="bi bi-briefcase-fill"></i></div>
            </div>
        </div>

        <!-- Expiring This Month -->
        <div class="col-xl-4 col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="fw-bold text-danger">Expiring This Month</h6>
                </div>
                <div class="card-body">
                    @forelse ($contractsExpiringThisMonth as $contract)
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <div>
                                <div class="fw-bold text-dark">{{ $contract->Name }}</div>
                                <div class="small text-muted">{{ $contract->type }}</div>
                            </div>
                            <span class="badge badge-danger-soft">
                                {{ \Carbon\Carbon::parse($contract->EndDate)->format('M d') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No contracts expiring this month.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Chart + Table -->
    <div class="row g-4 mt-1">

        <!-- Bar Chart -->
        <div class="col-xl-7">
            <div class="card p-3">
                <div class="card-header">
                    <h6 class="fw-bold text-primary">Contract Expiry by Month ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="expiryBarChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Upcoming Expirations Table -->
        <div class="col-xl-5">
            <div class="card p-3">
                <div class="card-header">
                    <h6 class="fw-bold text-primary">Upcoming Expirations</h6>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Contract</th>
                                <th>Type</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingExpirationsTable as $contract)
                                @php
                                    $endDate = \Carbon\Carbon::parse($contract->EndDate);
                                    $daysUntil = now()->diffInDays($endDate, false);

                                    $status = $daysUntil < 30 ? 'urgent' : ($daysUntil < 90 ? 'nearing' : 'far-out');
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $contract->Name }}</strong>
                                        <div class="small text-muted">
                                            {{ $contract->type === 'Employee' ? $contract->internalcontact->FirstName . ' ' . $contract->internalcontact->LastName : '' }}
                                        </div>
                                    </td>
                                    <td>{{ $contract->type }}</td>
                                    <td>{{ $endDate->format('d M, Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $status }}">
                                            {{ ucfirst(str_replace('-', ' ', $status)) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted p-4">
                                        No upcoming contract expirations this year.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const employeeData = {{ Js::from(array_values($employeeContractCounts)) }};
            const purchaseData = {{ Js::from(array_values($purchaseContractCounts)) }};
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            new Chart(document.getElementById('expiryBarChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: "Employee Contracts",
                            data: employeeData,
                            backgroundColor: "rgba(40, 167, 69, 0.7)",
                            borderColor: "rgba(40, 167, 69, 1)",
                            borderRadius: 6,
                        },
                        {
                            label: "Purchase Contracts",
                            data: purchaseData,
                            backgroundColor: "rgba(0, 123, 255, 0.7)",
                            borderColor: "rgba(0, 123, 255, 1)",
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e6e8ef'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });
        });
    </script>
@endsection
