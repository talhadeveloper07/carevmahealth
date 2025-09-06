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

    <div class="row d-flex justify-content-center mt-5">
    <div class="col-md-10">
                  <h6 class="text-body-secondary">Vertical</h6>
                  <div class="nav-align-left">
                    <ul class="nav nav-pills me-4" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-left-basic"
                          aria-controls="navs-pills-left-basic"
                          aria-selected="true">
                          Basic
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-left-work"
                          aria-controls="navs-pills-left-work"
                          aria-selected="false">
                          Work
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-left-hierarchy"
                          aria-controls="navs-pills-left-hierarchy"
                          aria-selected="false">
                          Hierarchy
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-left-personal"
                          aria-controls="navs-pills-left-personal"
                          aria-selected="false">
                          Personal
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-left-documents"
                          aria-controls="navs-pills-left-documents"
                          aria-selected="false">
                          Documents
                        </button>
                      </li>
                    </ul>
                    <form action="{{ route('insert.employee') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-left-basic" role="tabpanel">
                            <div class="mb-2">
                                <label class="form-label" for="multicol-first-name">First Name</label>
                                <input type="text" id="multicol-first-name" name='first_name' class="form-control @error('first_name') is-invalid @enderror" placeholder="John" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="multicol-last-name">Last Name</label>
                                <input type="text" id="multicol-last-name" name='last_name' class="form-control @error('last_name') is-invalid @enderror" placeholder="Doe" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="multicol-email">Email</label>
                                 <input
                                    type="text"
                                    id="multicol-email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name='email'
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                    aria-describedby="multicol-email2" />
                            </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-left-work" role="tabpanel">
                                    <div class="mb-2">
                                        <label class="form-label" for="department">Department</label>
                                        <select id="department" name='department' class="select form-select @error('department') is-invalid @enderror">
                                            <option>Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="role">Role</label>
                                        <select id="role" name='role' class="select form-select @error('role') is-invalid @enderror">
                                            <option>Select Role</option>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="employee_type">Employee Type</label>
                                        <select id="employee_type" name='employee_type' class="select form-select @error('employee_type') is-invalid @enderror">
                                            <option>Select Employee Type</option>
                                            @foreach($employmentTypes as $employmentType)
                                            <option value="{{ $employmentType->id }}">{{ $employmentType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="designation">Designation</label>
                                        <select id="designation" name='designation' class="select form-select @error('designation') is-invalid @enderror">
                                            <option>Select Designation</option>
                                            @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="shift_type">Shift Type</label>
                                        <select id="shift_type" name='shift_type' class="select form-select @error('shift_type') is-invalid @enderror">
                                            <option>Select Shift Type</option>
                                            @foreach($shiftTypes as $shiftType)
                                            <option value="{{ $shiftType->id }}">{{ $shiftType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="employee_status">Employee Status</label>
                                        <select id="employee_status" name='employee_status' class="select form-select @error('eployee_status') is-invalid @enderror">
                                            <option>Select Employee Status</option>
                                                @foreach($employeeStatuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="salary_pkr">Salary In PKR</label>
                                        <input type="text" id="salary_pkr" name='salary_pkr' class="form-control @error('salary_pkr') is-invalid @enderror" placeholder="500" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="salary_usd">Salary In USD</label>
                                        <input type="text" id="salary_usd" name='salary_usd' class="form-control @error('salary_usd') is-invalid @enderror" placeholder="500" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="source_of_hire">Source of Hire</label>
                                        <select id="source_of_hire" name='source_of_hire' class="select form-select @error('source_of_hire') is-invalid @enderror">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="joining_date">Date of Joining</label>
                                        <input type="date" name='joining_date' id='joining_date' class="form-control @error('joining_date') is-invalid @enderror" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="regularisation_date">Date of Regularisation</label>
                                        <input type="date" name='regularisation_date' id='regularisation_date' class="form-control" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="current_expertise">Current Expertise</label>
                                        <select id="current_expertise" name='current_expertise' class="select form-select">
                                            <option>Select Expertise</option>
                                            @foreach($expertises as $expertise)
                                            <option value="{{ $expertise->id }}">{{ $expertise->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="multicol-birthdate">Break Allowed(Hrs)</label>
                                        <input type="number" name="breaks" class="form-control" placeholder="0.00" step="0.01" min="0" />
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-left-hierarchy" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label" for="reporting_manager">Reporting Manager</label>
                                        <select id="reporting_manager" name='reporting_manager' class="select form-select">
                                            <option>Select Reporting Manager</option>
                                            @foreach($reportingManagers as $manager)
                                                <option value='{{ $manager->id }}'>{{$manager->name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-left-personal" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select id="gender" name='gender' class="select form-select">
                                        <option disabled>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                <label class="form-label" for="marital_status">Marital Status</label>
                                <select id="marital_status" name='marital_status' class="select form-select">
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>
                                </div>
                                <div class="mb-3 select2-primary">
                                    <label class="form-label" for="multicol-birthdate">Age</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="20"
                                        name='age' />
                                </div>
                                <div class="mb-3">
                                <label class="form-label" for="multicol-birthdate">Birth Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD"
                                    name='birth_date' />
                                </div>
                                <div class="mb-3">
                                    <label class='form-label' for="">About Me Notes</label>
                                    <textarea name="collapsible-notes"
                                        class="form-control"
                                        id="collapsible-notes"
                                        rows="2"
                                        name='notes'
                                        placeholder="write additional notes"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-left-documents" role="tabpanel">
                                <div class="mb-3">
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
                            <div class="mt-4 d-block">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
    </div>
</div>




@endsection



