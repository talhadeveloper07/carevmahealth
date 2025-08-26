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
                  <h4>{{ $employee->first_name }}'s Profile</h4>
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


@endsection



