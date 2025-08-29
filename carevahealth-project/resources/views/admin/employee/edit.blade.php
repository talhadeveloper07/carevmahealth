@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
                 <!-- Collapsible Section -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

        <form action="{{ route('update.employee', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')   
            <input type="hidden" name='employee_id' value='{{ $employee->id }}'>
            <div class="row my-6">
                <div class="col">
                @php
                    $isOnline = $employee->user->last_seen_at && $employee->user->last_seen_at->gt(now()->subMinutes(5));
                @endphp
                <div class="d-flex align-items-start gap-2">
                <h4>
                    {{ $employee->first_name }}'s Profile
                </h4>
                @if($isOnline)
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-secondary">Offline</span>
                    @endif
                </div>

                  <div class="accordion" id="collapsibleSection">
                    <div class="card accordion-item active">
                      <h2 class="accordion-header" id="headingBasicInformation">
                        <button
                          type="button"
                          class="accordion-button"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseBasicInformation"
                          aria-expanded="true"
                          aria-controls="collapseBasicInformation">
                          Basic Information
                        </button>
                      </h2>
                      <div
                        id="collapseBasicInformation"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#collapsibleSection">
                        <div class="accordion-body">
                        <div class="row g-6">
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">First Name</label>
                                <input type="text" id="multicol-first-name" value='{{ $employee->first_name }}' name='first_name' class="form-control @error('first_name') is-invalid @enderror" placeholder="John" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-last-name">Last Name</label>
                                <input type="text" id="multicol-last-name" value='{{ $employee->last_name }}' name='last_name' class="form-control @error('last_name') is-invalid @enderror" placeholder="Doe" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input
                                    type="text"
                                    id="multicol-email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name='email'
                                    value='{{ $employee->email }}'
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                    aria-describedby="multicol-email2" />
                                    <span class="input-group-text" id="multicol-email2">@example.com</span>
                                </div>
                                </div>
                                <!-- <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="multicol-password">Password</label>
                                    <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multicol-password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name='password'
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-password2"
                                        ><i class="icon-base ti tabler-eye-off"></i
                                    ></span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="multicol-confirm-password">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multicol-confirm-password"
                                        class="form-control"
                                        name='password_confirmation'
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-confirm-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                                        ><i class="icon-base ti tabler-eye-off"></i
                                    ></span>
                                    </div>
                                </div>
                                </div> -->
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingWorkInformation">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseWorkInformation"
                          aria-expanded="false"
                          aria-controls="collapseWorkInformation">
                          Work Information
                        </button>
                      </h2>
                      <div
                        id="collapseWorkInformation"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingWorkInformation"
                        data-bs-parent="#collapsibleSection">
                          <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="department">Department</label>
                                        <select id="department" name='department' class="select form-select @error('department') is-invalid @enderror">
                                            <option>Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="role">Role</label>
                                        <select id="role" name='role' class="select form-select @error('role') is-invalid @enderror">
                                            <option>Select Role</option>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role', $employee->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="employee_type">Employee Type</label>
                                        <select id="employee_type" name='employee_type' class="select form-select @error('employee_type') is-invalid @enderror">
                                            <option>Select Employee Type</option>
                                            @foreach($employmentTypes as $employmentType)
                                            <option value="{{ $employmentType->id }}"  {{ old('employee_type', $employee->employment_type_id) == $employmentType->id ? 'selected' : '' }}>{{ $employmentType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="designation">Designation</label>
                                        <select id="designation" name='designation' class="select form-select @error('designation') is-invalid @enderror">
                                            <option>Select Designation</option>
                                            @foreach($designations as $designations)
                                            <option value="{{ $designations->id }}" {{ old('designation', $employee->designation_id) == $designations->id ? 'selected' : '' }}>{{ $designations->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="shift_type">Shift Type</label>
                                        <select id="shift_type" name='shift_type' class="select form-select @error('shift_type') is-invalid @enderror">
                                            <option>Select Shift Type</option>
                                            @foreach($shiftTypes as $shiftType)
                                            <option value="{{ $shiftType->id }}" {{ old('shift_type', $employee->shift_type_id) == $shiftType->id ? 'selected' : '' }}>{{ $shiftType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="employee_status">Employee Status</label>
                                        <select id="employee_status" name='employee_status' class="select form-select @error('eployee_status') is-invalid @enderror">
                                            <option disabled>Select Employee Status</option>
                                                @foreach($employeeStatuses as $status)
                                                <option value="{{ $status->id }}" {{ old('employee_status', $employee->employee_status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="salary_pkr">Salary In PKR</label>
                                        <input type="text" id="salary_pkr" value='{{ $employee->salary_pkr }}' name='salary_pkr' class="form-control @error('salary_pkr') is-invalid @enderror" placeholder="500" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="salary_usd">Salary In USD</label>
                                        <input type="text" value='{{ $employee->salary_usd }}' id="salary_usd" name='salary_usd' class="form-control @error('salary_usd') is-invalid @enderror" placeholder="500" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="source_of_hire">Source of Hire</label>
                                        <select id="source_of_hire" name='source_of_hire' class="select form-select @error('source_of_hire') is-invalid @enderror">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="joining_date">Date of Joining</label>
                                        <input type="date" value='{{ $employee->date_of_joining }}' name='joining_date' id='joining_date' class="form-control @error('joining_date') is-invalid @enderror" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="regularisation_date">Date of Regularisation</label>
                                        <input type="date" value='{{ $employee->date_of_regularisation }}' name='regularisation_date' id='regularisation_date' class="form-control" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="current_expertise">Current Expertise</label>
                                        <select id="current_expertise" name='current_expertise' class="select form-select">
                                            <option disabled>Select Expertise</option>
                                            @foreach($expertises as $expertise)
                                            <option value="{{ $expertise->id }}" {{ old('current_expertise', $employee->expertise_id ) == $expertise->id ? 'selected' : '' }}>{{ $expertise->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Break Allowed(Hrs)</label>
                                        <input type="number" name="breaks" class="form-control" value='{{ $employee->break_allowed_hours }}' placeholder="0.00" step="0.01" min="0" />

                                    </div>
                                </div>
                          </div>
                      </div>
                    </div>

                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingHierarchyInformation">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseHierarchyInformation"
                          aria-expanded="false"
                          aria-controls="collapseHierarchyInformation">
                          Hierarchy Information
                        </button>
                      </h2>
                      <div
                        id="collapseHierarchyInformation"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingHierarchyInformation"
                        data-bs-parent="#collapsibleSection">
                        <div class="accordion-body">
                            <div class="row g-6">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="reporting_manager">Reporting Manager</label>
                                        <select id="reporting_manager" name='reporting_manager' class="select form-select">
                                            <option disabled>Select Reporting Manager</option>
                                            @foreach($reportingManagers as $manager)
                                             <option value='{{ $manager->id }}' {{ old('reporting_manager', $employee->reporting_manager_id ) == $manager->id ? 'selected' : '' }}>{{$manager->name}}</option>
                                             @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingPersonalinformation">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapsePersonalinformation"
                          aria-expanded="false"
                          aria-controls="collapsePersonalinformation">
                          Personal Information
                        </button>
                      </h2>
                      <div
                        id="collapsePersonalinformation"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingPersonalinformation"
                        data-bs-parent="#collapsibleSection">
                                <div class="accordion-body">
                                    <div class="row g-6">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select id="gender" name='gender' class="select form-select">
                                                <option disabled>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="form-label" for="marital_status">Marital Status</label>
                                        <select id="marital_status" name='marital_status' class="select form-select">
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                        </select>
                                        </div>
                                        <div class="col-md-6 select2-primary">
                                            <label class="form-label" for="multicol-birthdate">Age</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                placeholder="20"
                                                value='{{ $employee->age }}'
                                                name='age' />
                                        </div>
                                        <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Birth Date</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            placeholder="YYYY-MM-DD"
                                            name='birth_date'
                                            value='{{ $employee->date_of_birth }}'
                                             />
                                        </div>
                                        <div class="col-md-12">
                                            <label class='form-label' for="">About Me Notes</label>
                                            <textarea
                                                class="form-control"
                                                id="collapsible-notes"
                                                rows="2"
                                                name='notes'
                                                placeholder="write additional notes">{{ $employee->about_me_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingDocuments">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseDocuments"
                          aria-expanded="false"
                          aria-controls="collapseDocuments">
                          Documents
                        </button>
                      </h2>
                      <div
                        id="collapseDocuments"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingDocuments"
                        data-bs-parent="#collapsibleSection">
                                <div class="accordion-body">
                                    <div class="row g-6">
                                       
                                        <div class="col-12">
                                            <form action="/upload" class="dropzone needsclick dz-clickable" id="dropzone-multi">
                                                <div class="dz-message needsclick">
                                                Drop files here or click to upload
                                                <span class="note needsclick">you can add multiple documents here.</span>
                                                </div>
                                                <div class="fallback">
                                                <input name="file" type="file" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingTimezone">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseTimezone"
                          aria-expanded="false"
                          aria-controls="collapseTimezone">
                          Timezone
                        </button>
                      </h2>
                      <div
                        id="collapseTimezone"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingTimezone"
                        data-bs-parent="#collapsibleSection">
                                <div class="accordion-body">
                                    <div class="row g-6">
                                       
                                        <div class="col-12">
                                            <label for="timezone" class="form-label">Change Timezone</label>
                                            <select name="timezone" id="timezone" class="form-control">
                                                @foreach(timezone_identifiers_list() as $tz)
                                                    <option value="{{ $tz }}" {{ old('timezone', $employee->timezone) == $tz ? 'selected' : '' }}>
                                                        {{ $tz }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                  </div>
                </div>
              </div>
    </form>
</div>


<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 order-1 order-md-0">
                  <!-- User Card -->
                  <div class="card mb-6">
                    <div class="card-body pt-12">
                      <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                          <img
                            class="object-fit-cover rounded mb-4"
                            src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('assets/img/avatars/1.png') }}"
                            height="120"
                            width="120"
                            alt="User avatar" />
                          <div class="user-info text-center">
                            <h5>{{$employee->first_name}} {{$employee->last_name}}</h5>
                            <span class="badge bg-label-secondary">{{$employee->designation->name}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center me-5 gap-4">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                              <i class="icon-base ti tabler-checkbox icon-lg"></i>
                            </div>
                          </div>
                          <div>
                            <h5 class="mb-0">1.23k</h5>
                            <span>Task Done</span>
                          </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                          <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                              <i class="icon-base ti tabler-briefcase icon-lg"></i>
                            </div>
                          </div>
                          <div>
                            <h5 class="mb-0">568</h5>
                            <span>Project Done</span>
                          </div>
                        </div>
                      </div>
                      <h5 class="pb-4 border-bottom mb-4">Personal Details</h5>
                      <div class="info-container">
                        <ul class="list-unstyled mb-6">
                          <li class="mb-2">
                            <span class="h6">User ID:</span>
                            <span>{{ $employee->employee_code }}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Email:</span>
                            <span>{{$employee->email}}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Contact:</span>
                            <span>{{ $employee->phone }}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Status:</span>
                            <span>{{$employee->employeeStatus->name}}</span>
                          </li>
                        
                          <li class="mb-2">
                            <span class="h6">Age:</span>
                            <span>{{$employee->age}}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Gender:</span>
                            <span>{{$employee->gender}}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Marital Status:</span>
                            <span>{{$employee->marital_status}}</span>
                          </li>
                          <li class="mb-2">
                            <span class="h6">Timezone:</span>
                            <span>{{$employee->timezone}}</span>
                          </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                          <a
                            href="javascript:;"
                            class="btn btn-primary me-4"
                            data-bs-target="#editUser"
                            data-bs-toggle="modal"
                            >Edit</a
                          >
                          <a href="javascript:;" class="btn btn-label-danger suspend-user">Deactive</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /User Card -->
                  <!-- Plan Card -->
                  <div class="card mb-6 border border-2 border-primary rounded primary-shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-label-primary">Standard</span>
                        <div class="d-flex justify-content-center">
                          <sub class="h5 pricing-currency mb-auto mt-1 text-primary">$</sub>
                          <h1 class="mb-0 text-primary">99</h1>
                          <sub class="h6 pricing-duration mt-auto mb-3 fw-normal">month</sub>
                        </div>
                      </div>
                      <ul class="list-unstyled g-2 my-6">
                        <li class="mb-2 d-flex align-items-center">
                          <i class="icon-base ti tabler-circle-filled icon-10px text-secondary me-2"></i
                          ><span>10 Users</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                          <i class="icon-base ti tabler-circle-filled icon-10px text-secondary me-2"></i
                          ><span>Up to 10 GB storage</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                          <i class="icon-base ti tabler-circle-filled icon-10px text-secondary me-2"></i
                          ><span>Basic Support</span>
                        </li>
                      </ul>
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="h6 mb-0">Days</span>
                        <span class="h6 mb-0">26 of 30 Days</span>
                      </div>
                      <div class="progress mb-1 bg-label-primary" style="height: 6px">
                        <div
                          class="progress-bar"
                          role="progressbar"
                          style="width: 65%"
                          aria-valuenow="65"
                          aria-valuemin="0"
                          aria-valuemax="100"></div>
                      </div>
                      <small>4 days remaining</small>
                      <div class="d-grid w-100 mt-6">
                        <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                          Upgrade Plan
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- /Plan Card -->
                </div>
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 order-0 order-md-1">
                  <!-- User Pills -->
                  <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
                      <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"
                          ><i class="icon-base ti tabler-user-check icon-sm me-1_5"></i>Account</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="app-user-view-security.html"
                          ><i class="icon-base ti tabler-lock icon-sm me-1_5"></i>Security</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="app-user-view-billing.html"
                          ><i class="icon-base ti tabler-bookmark icon-sm me-1_5"></i>Billing & Plans</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="app-user-view-notifications.html"
                          ><i class="icon-base ti tabler-bell icon-sm me-1_5"></i>Notifications</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="app-user-view-connections.html"
                          ><i class="icon-base ti tabler-link icon-sm me-1_5"></i>Connections</a
                        >
                      </li>
                    </ul>
                  </div>
                  <!--/ User Pills -->

                  <!-- Project table -->
                  <div class="card mb-6">
                    <div class="table-responsive mb-4">
                      <table class="table datatable-project">
                        <thead class="border-top">
                          <tr>
                            <th></th>
                            <th></th>
                            <th>Project</th>
                            <th>Leader</th>
                            <th>Team</th>
                            <th class="w-px-200">Progress</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <!-- /Project table -->

                  <!-- Activity Timeline -->
                  <div class="card mb-6">
                    <h5 class="card-header">User Activity Timeline</h5>
                    <div class="card-body pt-1">
                      <ul class="timeline mb-0">
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-primary"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">12 Invoices have been paid</h6>
                              <small class="text-body-secondary">12 min ago</small>
                            </div>
                            <p class="mb-2">Invoices have been paid to the company</p>
                            <div class="d-flex align-items-center mb-2">
                              <div class="badge bg-lighter rounded d-flex align-items-center">
                                <img src="../../assets//img/icons/misc/pdf.png" alt="img" width="15" class="me-2" />
                                <span class="h6 mb-0 text-body">invoices.pdf</span>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-success"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">Client Meeting</h6>
                              <small class="text-body-secondary">45 min ago</small>
                            </div>
                            <p class="mb-2">Project meeting with john @10:15am</p>
                            <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                              <div class="d-flex flex-wrap align-items-center mb-50">
                                <div class="avatar avatar-sm me-2">
                                  <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div>
                                  <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                  <small>CEO of Pixinvent</small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-info"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-3">
                              <h6 class="mb-0">Create a new project for client</h6>
                              <small class="text-body-secondary">2 Day Ago</small>
                            </div>
                            <p class="mb-2">6 team members in a project</p>
                            <ul class="list-group list-group-flush">
                              <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                                <div class="d-flex flex-wrap align-items-center">
                                  <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Vinnie Mostowy"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                                    </li>
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Allen Rieske"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                                    </li>
                                    <li
                                      data-bs-toggle="tooltip"
                                      data-popup="tooltip-custom"
                                      data-bs-placement="top"
                                      title="Julee Rossignol"
                                      class="avatar pull-up">
                                      <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                                    </li>
                                    <li class="avatar">
                                      <span
                                        class="avatar-initial rounded-circle pull-up"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="3 more"
                                        >+3</span
                                      >
                                    </li>
                                  </ul>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- /Activity Timeline -->

                  <!-- Invoice table -->
                  <div class="card mb-4">
                    <div class="card-datatable table-responsive">
                      <table class="table datatable-invoice">
                        <thead>
                          <tr>
                            <th></th>
                            <th>#</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Issued Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <!-- /Invoice table -->
                </div>
                <!--/ User Content -->
              </div>

              <!-- Modal -->
              <!-- Edit User Modal -->
              <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                  <div class="modal-content">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-6">
                        <h4 class="mb-2">Edit User Information</h4>
                        <p>Updating user details will receive a privacy audit.</p>
                      </div>
                      <form id="editUserForm" class="row g-6" onsubmit="return false">
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserFirstName">First Name</label>
                          <input
                            type="text"
                            id="modalEditUserFirstName"
                            name="modalEditUserFirstName"
                            class="form-control"
                            placeholder="John"
                            value="John" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserLastName">Last Name</label>
                          <input
                            type="text"
                            id="modalEditUserLastName"
                            name="modalEditUserLastName"
                            class="form-control"
                            placeholder="Doe"
                            value="Doe" />
                        </div>
                        <div class="col-12">
                          <label class="form-label" for="modalEditUserName">Username</label>
                          <input
                            type="text"
                            id="modalEditUserName"
                            name="modalEditUserName"
                            class="form-control"
                            placeholder="johndoe007"
                            value="johndoe007" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserEmail">Email</label>
                          <input
                            type="text"
                            id="modalEditUserEmail"
                            name="modalEditUserEmail"
                            class="form-control"
                            placeholder="example@domain.com"
                            value="example@domain.com" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserStatus">Status</label>
                          <select
                            id="modalEditUserStatus"
                            name="modalEditUserStatus"
                            class="select2 form-select"
                            aria-label="Default select example">
                            <option selected>Status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                            <option value="3">Suspended</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditTaxID">Tax ID</label>
                          <input
                            type="text"
                            id="modalEditTaxID"
                            name="modalEditTaxID"
                            class="form-control modal-edit-tax-id"
                            placeholder="123 456 7890"
                            value="123 456 7890" />
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserPhone">Phone Number</label>
                          <div class="input-group">
                            <span class="input-group-text">US (+1)</span>
                            <input
                              type="text"
                              id="modalEditUserPhone"
                              name="modalEditUserPhone"
                              class="form-control phone-number-mask"
                              placeholder="202 555 0111"
                              value="202 555 0111" />
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserLanguage">Language</label>
                          <select
                            id="modalEditUserLanguage"
                            name="modalEditUserLanguage"
                            class="select2 form-select"
                            multiple>
                            <option value="">Select</option>
                            <option value="english" selected>English</option>
                            <option value="spanish">Spanish</option>
                            <option value="french">French</option>
                            <option value="german">German</option>
                            <option value="dutch">Dutch</option>
                            <option value="hebrew">Hebrew</option>
                            <option value="sanskrit">Sanskrit</option>
                            <option value="hindi">Hindi</option>
                          </select>
                        </div>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserCountry">Country</label>
                          <select
                            id="modalEditUserCountry"
                            name="modalEditUserCountry"
                            class="select2 form-select"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="Australia">Australia</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Brazil">Brazil</option>
                            <option value="Canada">Canada</option>
                            <option value="China">China</option>
                            <option value="France">France</option>
                            <option value="Germany">Germany</option>
                            <option value="India" selected>India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Japan">Japan</option>
                            <option value="Korea">Korea, Republic of</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Russia">Russian Federation</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                          </select>
                        </div>
                        <div class="col-12">
                          <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="editBillingAddress" />
                            <label for="editBillingAddress" class="switch-label">Use as a billing address?</label>
                          </div>
                        </div>
                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary me-3">Submit</button>
                          <button
                            type="reset"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Edit User Modal -->

              <!-- Add New Credit Card Modal -->
              <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                  <div class="modal-content">
                    <div class="modal-body p-4">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-6">
                        <h2>Upgrade Plan</h2>
                        <p class="text-body-secondary">Choose the best plan for user.</p>
                      </div>
                      <form id="upgradePlanForm" class="row g-4" onsubmit="return false">
                        <div class="col-sm-9">
                          <label class="form-label" for="choosePlan">Choose Plan</label>
                          <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                            <option selected>Choose Plan</option>
                            <option value="standard">Standard - $99/month</option>
                            <option value="exclusive">Exclusive - $249/month</option>
                            <option value="Enterprise">Enterprise - $499/month</option>
                          </select>
                        </div>
                        <div class="col-sm-3 d-flex align-items-end">
                          <button type="submit" class="btn btn-primary">Upgrade</button>
                        </div>
                      </form>
                    </div>
                    <hr class="mx-md-n5 mx-n3" />
                    <div class="modal-body">
                      <h6 class="mb-0">User current plan is standard plan</h6>
                      <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex justify-content-center me-2 mt-1">
                          <sup class="h6 pricing-currency pt-1 mt-2 mb-0 me-1 text-primary">$</sup>
                          <h1 class="mb-0 text-primary">99</h1>
                          <sub class="pricing-duration mt-auto mb-5 pb-1 small text-body">/month</sub>
                        </div>
                        <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Add New Credit Card Modal -->

              <!-- /Modal -->
            </div>
@endsection



