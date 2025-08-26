@extends('employee.layouts.app')
@section('employee_content')


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">

            @php
            use Illuminate\Support\Facades\Auth;
            $employee = \App\Models\Employee::where('user_id', Auth::id())->first();
            @endphp



                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
        <div class="col-md-12">
        @if($employee && !$employee->profile_completed)
            <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert" style="z-index: 1050;">
                <div>
                    ⚠️ <strong>Complete Your Profile:</strong> You must complete your profile before using the system.
                </div>
            </div>
        @endif
        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row my-6">
                <div class="col">
                  <h4>My Profile</h4>
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
                            <div class="d-flex align-items-center gap-3">
                            <img id="previewImage" src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('assets/img/avatars/1.png') }}" alt="" style='border-radius:8px;width:100px;height:100px;object-fit:cover;' class='mb-2'>
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-3 mb-4 waves-effect waves-light" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
                                            <input type="file" name='profile_picture' id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                        </label>
                                        <button type="button" id='resetBtn' class="btn btn-label-secondary account-image-reset mb-4 waves-effect">
                                            <i class="icon-base ti tabler-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                            </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-first-name">First Name</label>
                                <input type="text" id="multicol-first-name" name='first_name' value='{{ $employee->first_name }}'  class="form-control @error('first_name') is-invalid @enderror" placeholder="John" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-last-name">Last Name</label>
                                <input type="text" id="multicol-last-name" name='last_name' value='{{ $employee->last_name }}' class="form-control @error('last_name') is-invalid @enderror" placeholder="Doe" />
                                </div>
                                <div class="col-md-6">
                                <label class="form-label" for="multicol-email">Email</label>
                                <div class="input-group">
                                    <input
                                    type="text"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name='email'
                                    value='{{ $employee->email }}'
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                     />
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
                                                name='age'
                                                value='{{ $employee->age }}' />
                                        </div>
                                        <div class="col-md-6">
                                        <label class="form-label" for="multicol-birthdate">Birth Date</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            name='date_of_birth'
                                            value='{{ $employee->date_of_birth }}' />
                                        </div>
                                        <div class="col-md-12">
                                            <label class='form-label' for="">About Me Notes</label>
                                            <textarea name="collapsible-notes"
                                                class="form-control"
                                                id="collapsible-notes"
                                                rows="2"
                                                name='notes'
                                                >{{ $employee->about_me_notes }}</textarea>
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
               
            </form>
                

        </div>
    </div>
</div>

<script>
    const uploadInput = document.getElementById('upload');
    const previewImage = document.getElementById('previewImage');
    const resetBtn = document.getElementById('resetBtn');

    const defaultImage = previewImage.src;

    uploadInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // show new image
            }
            reader.readAsDataURL(file);
        }
    });

    resetBtn.addEventListener('click', function() {
        previewImage.src = defaultImage; // reset to default
        uploadInput.value = ""; // clear file input
    });
</script>
@endsection





