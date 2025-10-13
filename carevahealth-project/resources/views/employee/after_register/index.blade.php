
@extends('layouts.app')

@section('content')

<div class="vh-100">
    <div class="row h-100" style="background-image: url('/VMA-Hero_Image.jpg'); height: 100%;background-size:cover;">
        <!-- Left side -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="welcome-text-div animate-slide-left">
                <h2>Welcome to CareVMA Health</h2>
                <p>Thanks for joining! Complete your profile so we can match you with the right shifts, teams and payments.</p>
                <a href="{{ route('complete.your.profile', $employee->id) }}" 
   class="complete-profile-btn">
   Complete Your Profile
</a>

            </div>
        </div>

        <!-- Right side -->
        <div class="col-md-6 p-0">
            
        </div>
    </div>
</div>


@endsection