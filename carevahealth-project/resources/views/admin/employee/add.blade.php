@extends('admin.layouts.app')
@section('admin_content')

<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />

<div class="container-xxl flex-grow-1 container-p-y">
                 <!-- Collapsible Section -->
            <div class="row my-6">
                <div class="col">
                  <h4>Add New Employee</h4>
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
                                <input type="text" id="multicol-first-name" class="form-control" placeholder="John" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-last-name">Last Name</label>
                                <input type="text" id="multicol-last-name" class="form-control" placeholder="Doe" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input
                                    type="text"
                                    id="multicol-email"
                                    class="form-control"
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                    aria-describedby="multicol-email2" />
                                    <span class="input-group-text" id="multicol-email2">@example.com</span>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-password-toggle">
                                    <label class="form-label" for="multicol-password">Password</label>
                                    <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multicol-password"
                                        class="form-control"
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
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-confirm-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                                        ><i class="icon-base ti tabler-eye-off"></i
                                    ></span>
                                    </div>
                                </div>
                                </div>
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
                                        <select id="department" name='department' class="select form-select">
                                            <option selected>Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="role">Role</label>
                                        <select id="role" name='role' class="select form-select">
                                            <option selected>Select Role</option>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="role">Employee Type</label>
                                        <select id="role" name='role' class="select form-select">
                                            <option selected>Select Employee Type</option>
                                            @foreach($employmentTypes as $employmentType)
                                            <option value="{{ $employmentType->id }}">{{ $employmentType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="designation">Designation</label>
                                        <select id="designation" name='designation' class="select form-select">
                                            <option selected>Select Designation</option>
                                            @foreach($designations as $designations)
                                            <option value="{{ $designations->id }}">{{ $designations->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="shift_type">Shift Type</label>
                                        <select id="shift_type" name='shift_type' class="select form-select">
                                            <option selected>Select Shift Type</option>
                                            @foreach($shiftTypes as $shiftType)
                                            <option value="{{ $shiftType->id }}">{{ $shiftType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="employee_status">Employee Status</label>
                                        <select id="employee_status" name='employee_status' class="select form-select">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="multicol-last-name">Salary In PKR</label>
                                        <input type="text" id="salary_pkr" name='salary_pkr' class="form-control" placeholder="500" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="multicol-last-name">Salary In USD</label>
                                        <input type="text" id="salary_pkr" name='salary_usd' class="form-control" placeholder="500" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="source_of_hire">Source of Hire</label>
                                        <select id="source_of_hire" name='source_of_hire' class="select form-select">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Date of Joining</label>
                                        <input type="date" class="form-control" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Date of Regularisation</label>
                                        <input type="date" class="form-control" placeholder="YYYY-MM-DD" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="source_of_hire">Current Expertise</label>
                                        <select id="source_of_hire" name='source_of_hire' class="select form-select">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Break Allowed(Hrs)</label>
                                        <input type="number" class="form-control" placeholder="00" />
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
                                        <label class="form-label" for="source_of_hire">Reporting Manager</label>
                                        <select id="source_of_hire" name='source_of_hire' class="select form-select">
                                            <option value="seo" selected>SEO</option>
                                            <option value="sales">Sales</option>
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
                                        <div class="col-md-6">
                                        <label class="form-label" for="marital-status">Marital Status</label>
                                        <select id="marital-status" name='marital-status' class="select form-select">
                                            <option value="single" selected>Single</option>
                                            <option value="married">Married</option>
                                        </select>
                                        </div>
                                        <div class="col-md-6 select2-primary">
                                            <label class="form-label" for="multicol-birthdate">Age</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                placeholder="20" />
                                        </div>
                                        <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Birth Date</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            placeholder="YYYY-MM-DD" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class='form-label' for="">About Me Notes</label>
                                            <textarea name="collapsible-notes"
                                                class="form-control"
                                                id="collapsible-notes"
                                                rows="2"
                                                placeholder="write additional notes"></textarea>
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
                                            <form action="/upload" class="dropzone needsclick" id="dropzone-multi">
                                                <div class="dz-message needsclick">
                                                Drop files here or click to upload
                                                <span class="note needsclick"
                                                    >you can add multiple documents here.</span
                                                >
                                                </div>
                                                <div class="fallback">
                                                <input name="file" type="file" />
                                                </div>
                                            </form>
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
</div>


@endsection



