@extends('employee.layouts.app')
@section('employee_content')


<style>
    button.remove-doc {
    position: absolute;
    right: -9px;
    top: -9px;
    border-radius: 50px;
    width: 20px;
    height: 20px;
    background: red;
    border: 0;
    color: white;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
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
        </div>

    </div>

      <div class="col-12 mb-6">
                  <div class="bs-stepper wizard-numbered mt-2">
                    <div class="bs-stepper-header">
                      <div class="step" data-target="#account-details">
                        <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">1</span>
                          <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Account Details</span>
                            <span class="bs-stepper-subtitle">Setup Account Details</span>
                          </span>
                        </button>
                      </div>
                      <div class="line">
                        <i class="icon-base ti tabler-chevron-right"></i>
                      </div>
                      <div class="step" data-target="#personal-info">
                        <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">2</span>
                          <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Personal Info</span>
                            <span class="bs-stepper-subtitle">Add personal info</span>
                          </span>
                        </button>
                      </div>
                      <div class="line">
                        <i class="icon-base ti tabler-chevron-right"></i>
                      </div>
                      <div class="step" data-target="#social-links">
                        <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">3</span>
                          <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Documents</span>
                            <span class="bs-stepper-subtitle">Add your Documents</span>
                          </span>
                        </button>
                      </div>
                    </div>
                    <div class="bs-stepper-content">
                        <!-- Account Details -->
                        <div id="account-details" class="content">
                          <div class="content-header mb-4">
                            <h6 class="mb-0">Account Details</h6>
                            <small>Enter Your Account Details.</small>
                          </div>
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
                            <div class="col-sm-6">
                              <label class="form-label" for="multicol-first-name">First Name</label>
                              <input type="text" id="multicol-first-name" name='first_name' value='{{ $employee->first_name }}'  class="form-control @error('first_name') is-invalid @enderror" placeholder="John" />
                            </div>
                            <div class="col-sm-6">
                              <label class="form-label" for="multicol-last-name">Last Name</label>
                              <input type="text" id="multicol-last-name" name='last_name' value='{{ $employee->last_name }}'  class="form-control @error('last_name') is-invalid @enderror" placeholder="John" />
                            </div>
                            <div class="col-sm-6">
                              <label class="form-label" for="email">Email</label>
                              <div class="input-group">
                                    <input
                                    type="text"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name='email'
                                    value='{{ $employee->email }}'
                                    placeholder="john.doe"
                                    aria-label="john.doe"
                                    disabled
                                     />
                                </div>
                            </div>
                           
                            <div class="col-12 d-flex justify-content-between">
                              <button class="btn btn-label-secondary btn-prev" disabled>
                                <i class="icon-base ti tabler-arrow-left icon-xs me-sm-2 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                              </button>
                              <button class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                <i class="icon-base ti tabler-arrow-right icon-xs"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <!-- Personal Info -->
                        <div id="personal-info" class="content">
                          <div class="content-header mb-4">
                            <h6 class="mb-0">Personal Info</h6>
                            <small>Enter Your Personal Info.</small>
                          </div>
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
                                            <textarea
                                                class="form-control"
                                                id="collapsible-notes"
                                                rows="2"
                                                name='about_me_notes'
                                                >{{ $employee->about_me_notes }}</textarea>
                                        </div>
                                    </div>
                        </div>
                        <!-- Documents -->
                        <!-- Documents Section -->
                        <div id="social-links" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Documents</h6>
                            <small>Add Your Documents</small>
                        </div>
                        <div class="row g-6">
                                <form action="{{ route('employee.profile.update') }}"
                                    method="POST"
                                    class="dropzone"
                                    id="dropzone-multi"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="field" value="upload_documents">

                                    <div class="dz-message needsclick">
                                        Drop files here or click to upload
                                        <span class="note needsclick">You can add multiple documents here.</span>
                                    </div>

                                    <div class="fallback">
                                        <input name="value" type="file" multiple />
                                    </div>
                                </form>

                            <div class="col-12 mt-4">
                            <h6>Uploaded Documents</h6>
                                <div id="uploaded-documents">
                                    @if(!empty($employee->upload_documents))
                                        @foreach($employee->upload_documents as $index => $doc)
                                            @php
                                                $path = asset('storage/' . $doc);
                                                $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                            @endphp

                                            <div class="doc-item d-inline-block text-center m-2 position-relative" data-index="{{ $index }}">
                                                <button type="button" class="remove-doc" data-index="{{ $index }}" data-path="{{ $doc }}">
                                                    &times;
                                                </button>

                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                                    <a class='w-100 d-block' href="{{ $path }}" target="_blank">
                                                        <img src="{{ $path }}" alt="doc" style="max-width:100px; max-height:100px; border-radius:6px;">
                                                    </a>
                                                @elseif($ext === 'pdf')
                                                    <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i class="fa fa-file-pdf fa-3x text-danger"></i></a>
                                                @elseif(in_array($ext, ['doc','docx']))
                                                    <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i class="fa fa-file-word fa-3x text-primary"></i></a>
                                                @else
                                                    <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i class="fa fa-file fa-3x text-secondary"></i></a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif


                                </div>

                            </div>
                        </div>
                        </div>

                    </div>
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

<script>
$(document).ready(function(){

    // Text, number, textarea, select
    $(document).on("change", "input:not([type=file]), textarea, select", function() {
        let field = $(this).attr("name");
        let value = $(this).val();

        $.ajax({
            url: "{{ route('employee.profile.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                field: field,
                value: value
            },
            success: function(res) {
                console.log("Saved:", res);
            },
            error: function(err) {
                console.error(err.responseJSON);
            }
        });
    });

    // File upload (profile picture)
    $(document).on("change", "input[type=file][name=profile_picture]", function() {
        let field = $(this).attr("name");
        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("field", field);
        formData.append("value", this.files[0]);

        $.ajax({
            url: "{{ route('employee.profile.update') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.value) {
                    $("#previewImage").attr("src", res.value);
                }
                console.log("Image uploaded:", res);
            },
            error: function(err) {
                console.error(err.responseJSON);
            }
        });
    });

});
</script>

<!-- <script src="/assets/vendor/libs/dropzone/dropzone.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
Dropzone.options.dropzoneMulti = {
    paramName: "value", // must match controller input
    maxFilesize: 25, // MB
    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
    acceptedFiles: ".pdf,.doc,.docx,.jpg,.jpeg,.png",
    init: function () {
        this.on("sending", function (file, xhr, formData) {
            console.log("Sending file:", file.name);
        });

        this.on("success", function (file, response) {
            console.log("Upload success:", response);

            if (response.success && response.value) {
                $("#uploaded-documents").append(
                    `<span class="badge bg-info"><a clas='text-white' href="${response.value}" target="_blank">${file.name}</a></span><br>`
                );
            }
        });

        this.on("error", function (file, errorMessage) {
            console.error("Upload error:", errorMessage);
        });
    }
};

$(document).on("click", ".remove-doc", function () {
    let button = $(this);
    let index = button.data("index");
    let path = button.data("path");

    $.ajax({
        url: "{{ route('employee.profile.delete.document') }}", // new route
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            index: index,
            path: path
        },
        success: function (res) {
            if (res.success) {
                button.closest(".doc-item").remove(); // remove from UI
            } else {
                alert(res.message);
            }
        },
        error: function (err) {
            console.error(err.responseJSON);
        }
    });
});

</script>




@endsection





