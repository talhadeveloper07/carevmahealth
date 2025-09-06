@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
    @include('admin.client.profile_layouts.header')
    @include('admin.client.profile_layouts.nav')
    <div class="row">
        <div class="col-xl-12 col-lg-12 order-0 order-md-1">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                    
                            @foreach ($errors->all() as $error)
                                <p class='p-0 mb-1'>{{ $error }}</p>
                            @endforeach
                    
                    </div>
                @endif

                <h3>Welcome {{ $client->name }} to your Profile.</h3>
        </div>
    </div>
</div>


@endsection
