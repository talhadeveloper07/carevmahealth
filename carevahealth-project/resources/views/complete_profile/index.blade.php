@extends('layouts.app')
@section('content')
<div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
          <!-- Reset Password -->
          <div class="row d-flex justify-content-center">
            <div class="col-md-5">
            <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="/" class="app-brand-link">
                  <span class="app-brand-text demo text-heading fw-bold">Care VMA Health</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Reset Password 🔒</h4>
              <p class="mb-6">
                <span class="fw-medium">Your new password must be different from previously used passwords</span>
            </p>
            <form id="formAuthentication" action="{{ url('/complete-profile/'.$employee->id) }}" method="POST">
    @csrf

    {{-- Password --}}
    <div class="mb-6 form-password-toggle form-control-validation">
        <label class="form-label" for="password">New Password</label>
        <div class="input-group input-group-merge">
            <input
                type="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
        @error('password')
            <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-6 form-password-toggle form-control-validation">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="input-group input-group-merge">
            <input
                type="password"
                id="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                name="password_confirmation"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
        </div>
        @error('password_confirmation')
            <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
    </div>

    {{-- Gender --}}
    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('gender')
            <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
    </div>

    {{-- Date of Birth --}}
    <div class="mb-3">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control @error('date_of_birth') is-invalid @enderror" required>
        @error('date_of_birth')
            <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
    </div>

    {{-- About Me --}}
    <div class="mb-3">
        <label>About Me</label>
        <textarea name="about_me_notes" class="form-control @error('about_me_notes') is-invalid @enderror">{{ old('about_me_notes') }}</textarea>
        @error('about_me_notes')
            <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary d-grid w-100 mb-6">Set new password</button>
    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex justify-content-center">
            <i class="icon-base ti tabler-chevron-left scaleX-n1-rtl me-1_5"></i>
            Back to login
        </a>
    </div>
</form>

            </div>
          </div>
            </div>
          </div>
          <!-- /Reset Password -->
        </div>
      </div>

@endsection