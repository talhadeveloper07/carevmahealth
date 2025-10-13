@extends('admin.layouts.app')
@section('admin_content')

    {{-- ✅ CSS for Wave Effect --}}
    <style>
        .pulse-icon {
            position: relative;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            overflow: visible;
        }

        .pulse-icon::after {
            content: "";
            position: absolute;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid currentColor;
            animation: pulseWave 1.5s infinite;
            opacity: 0.6;
        }

        @keyframes pulseWave {
            0% {
                transform: scale(0.6);
                opacity: 0.8;
            }

            70% {
                transform: scale(1.3);
                opacity: 0;
            }

            100% {
                transform: scale(0.6);
                opacity: 0;
            }
        }
    </style>


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6 d-flex align-items-center justify-content-center">
            <!-- Card Border Shadow -->
           <div class="col-md-10">
                <div class="row">
                <div class="col-lg-4 col-sm-6">
                <div class="card-border-shadow-primary h-100">
                    <div class="custom-card-body dashboard-card h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="icon-base ti tabler-truck icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $clientsCount }}</h4>
                        </div>
                        <p class="mb-1">Total Clients</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">{{ $newClientsLast30 }}+</span>
                            <small class="text-body-secondary">new in last 30 days</small>
                        </p>
                    </div>
                </div>


            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card-border-shadow-warning h-100">
                    <div class="custom-card-body dashboard-card h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="icon-base ti tabler-alert-triangle icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{ $employeesCount }}</h4>
                        </div>
                        <p class="mb-1">Total Employees</p>
                        <p class="mb-0">
                            <span class="text-heading fw-medium me-2">{{ $newEmployeesLast30 }}+</span>
                            <small class="text-body-secondary">new in last 30 days</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card-border-shadow-success h-100">
                    <div class="custom-card-body dashboard-card h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4 position-relative">
                                <span class="avatar-initial rounded bg-label-success pulse-icon">
                                    <i class="ti ti-login rounded icon-12px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0" id="checkedInCount">0</h4>
                        </div>
                        <p class="mb-1">Today Live Employees</p>
                    </div>
                </div>
            </div>
                </div>
           </div>
        </div>
    </div>



    {{-- ✅ Script --}}
    <script>
        function loadAttendanceStats() {
            fetch("{{ route('attendance.stats') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('checkedInCount').innerText = data.checkedIn;
                })
                .catch(error => console.error('Error fetching stats:', error));
        }

        loadAttendanceStats();

        setInterval(loadAttendanceStats, 1000);
    </script>

@endsection