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
        <div class="row d-flex align-items-center justify-content-center mb-3">
            @php
                use Illuminate\Support\Facades\Auth;
                $employee = \App\Models\Employee::where('user_id', Auth::id())->first();
            @endphp

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="col-md-10">
                @if($employee && !$employee->profile_completed)
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert"
                        style="z-index: 1050;">
                        <div>
                            ⚠️ <strong>Complete Your Profile:</strong> You must complete your profile before using the system.
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class='row d-flex justify-content-center mt-5 align-items-center mb-5'>
            <div class="col-md-5 custom-title-col">
                <h4 class='mb-0 custom-page-title'>My Profile</h4>
                <p>you can update your details.</p>
            </div>
            <div class="col-md-5 justify-content-end d-flex align-items-center gap-3">

            </div>

            <div class="col-md-10 mt-5">
                @if(session('success'))
                    <div class="alert alert-solid-success d-flex align-items-center" role="alert">
                        <span class="alert-icon rounded">
                            <i class="icon-base ti tabler-check icon-md"></i>
                        </span>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                        <span class="alert-icon rounded">
                            <i class="icon-base ti tabler-ban icon-md"></i>
                        </span>
                        {{ implode(' | ', $errors->all()) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row d-flex justify-content-center form-row">
            <div class="col-md-10">
                <div class="nav-align-left">
                    <ul class="nav nav-pills me-4" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-left-basic" aria-controls="navs-pills-left-basic"
                                aria-selected="true">
                                Basic
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-left-personal" aria-controls="navs-pills-left-personal"
                                aria-selected="false">
                                Personal
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-left-documents" aria-controls="navs-pills-left-documents"
                                aria-selected="false">
                                Documents
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-left-timezone" aria-controls="navs-pills-left-timezone"
                                aria-selected="false">
                                Timezone
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-left-basic" role="tabpanel">
                            <div class="d-flex align-items-center gap-3">
                                <img id="previewImage"
                                    src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('assets/img/avatars/1.png') }}"
                                    alt="" style='border-radius:8px;width:100px;height:100px;object-fit:cover;'
                                    class='mb-2'>
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-3 mb-4 waves-effect waves-light"
                                        tabindex="0">
                                        <span class="d-none d-sm-block text-white">Upload new photo</span>
                                        <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
                                        <input type="file" name='profile_picture' id="upload" class="account-file-input"
                                            hidden="" accept="image/png, image/jpeg">
                                    </label>
                                    <button type="button" id='resetBtn'
                                        class="btn btn-label-secondary account-image-reset mb-4 waves-effect">
                                        <i class="icon-base ti tabler-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <input type="hidden" name='employee_id' value='{{ $employee->id }}'>
                                <label class="form-label" for="multicol-first-name">First Name</label>
                                <input type="text" id="multicol-first-name" value='{{ $employee->first_name }}'
                                    name='first_name' class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="John" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="multicol-last-name">Last Name</label>
                                <input type="text" id="multicol-last-name" value='{{ $employee->last_name }}'
                                    name='last_name' class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Doe" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="multicol-email">Email</label>
                                <input type="text" id="multicol-email"
                                    class="form-control @error('email') is-invalid @enderror" name='email'
                                    value='{{ $employee->email }}' aria-label="john.doe"
                                    aria-describedby="multicol-email2" />
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
                                <input type="number" class="form-control" placeholder="20" value='{{ $employee->age }}'
                                    name='age' />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="multicol-birthdate">Birth Date</label>
                                <input type="date" class="form-control" placeholder="YYYY-MM-DD" name='birth_date'
                                    value='{{ $employee->date_of_birth }}' />
                            </div>
                            <div class="col-md-12">
                                <label class='form-label' for="">About Me Notes</label>
                                <textarea class="form-control" id="collapsible-notes" rows="2" name='notes'
                                    placeholder="write additional notes">{{ $employee->about_me_notes }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-left-documents" role="tabpanel">
                            <form action="{{ route('employee.profile.update') }}" method="POST" class="dropzone"
                                id="dropzone-multi" enctype="multipart/form-data">
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
                            <div id="uploaded-documents">
                                @if(!empty($employee->upload_documents))
                                    @foreach($employee->upload_documents as $index => $doc)
                                        @php
                                            $path = asset('storage/' . $doc);
                                            $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                        @endphp

                                        <div class="doc-item d-inline-block text-center m-2 position-relative"
                                            data-index="{{ $index }}">
                                            <button type="button" class="remove-doc" data-index="{{ $index }}"
                                                data-path="{{ $doc }}">&times;</button>

                                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <a class='w-100 d-block' href="{{ $path }}" target="_blank">
                                                    <img src="{{ $path }}" alt="doc"
                                                        style="max-width:100px; max-height:100px; border-radius:6px;">
                                                </a>
                                            @elseif($ext === 'pdf')
                                                <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i
                                                        class="fa fa-file-pdf fa-3x text-danger"></i></a>
                                            @elseif(in_array($ext, ['doc', 'docx']))
                                                <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i
                                                        class="fa fa-file-word fa-3x text-primary"></i></a>
                                            @else
                                                <a class='w-100 d-block' href="{{ $path }}" target="_blank"><i
                                                        class="fa fa-file fa-3x text-secondary"></i></a>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-left-timezone" role="tabpanel">
                            <div class="col-12">
                                <label for="timezone" class="form-label">Change Timezone</label>
                                <select name="timezone" id="timezone" class="form-control" disabled>
                                    @foreach(timezone_identifiers_list() as $tz)
                                        <option value="{{ $tz }}" {{ old('timezone', $employee->timezone) == $tz ? 'selected' : '' }}>
                                            {{ $tz }}
                                        </option>
                                    @endforeach
                                </select>
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

        uploadInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result; // show new image
                }
                reader.readAsDataURL(file);
            }
        });

        resetBtn.addEventListener('click', function () {
            previewImage.src = defaultImage; // reset to default
            uploadInput.value = ""; // clear file input
        });
    </script>

    <script>
        $(document).ready(function () {

            // Text, number, textarea, select
            $(document).on("change", "input:not([type=file]), textarea, select", function () {
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
                    success: function (res) {
                        console.log("Saved:", res);
                    },
                    error: function (err) {
                        console.error(err.responseJSON);
                    }
                });
            });

            // File upload (profile picture)
            $(document).on("change", "input[type=file][name=profile_picture]", function () {
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
                    success: function (res) {
                        if (res.value) {
                            $("#previewImage").attr("src", res.value);
                        }
                        console.log("Image uploaded:", res);
                    },
                    error: function (err) {
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