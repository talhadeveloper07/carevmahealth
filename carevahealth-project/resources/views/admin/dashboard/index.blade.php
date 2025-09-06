@extends('admin.layouts.app')
@section('admin_content')


<div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6 d-flex justify-content-center mt-5">
            <div class="col-md-10">
                <div class="row">
                <div class="col-lg-3 col-sm-6">
                <div class=" card-border-shadow-primary h-100">
                    <div class="custom-card-body">
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
            <div class="col-lg-3 col-sm-6">
                <div class=" card-border-shadow-warning h-100">
                    <div class="custom-card-body">
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
            <div class="col-lg-3 col-sm-6">
           
                    <div class=" card-border-shadow-success h-100">
                        <div class="custom-card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="ti ti-login icon-28px"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0" id="checkedInCount">0</h4>
                            </div>
                            <p class="mb-1">Currently Checked In</p>
                        </div>
                    </div>
                </div>
        
            <div class="col-lg-3 col-sm-6">
          
                <div class=" card-border-shadow-danger h-100">
                    <div class="custom-card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-logout icon-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0" id="checkedOutCount">0</h4>
                        </div>
                        <p class="mb-1">Already Checked Out</p>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
</div>



@endsection