@extends('admin.layouts.app')
@section('admin_content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class='m-0'>Add New Client</h4>
        <a href="{{ route('all.clients') }}" class='btn btn-primary'>All Clients</a>
    </div>
   <div class="card">
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class='list-unstyled p-0 m-0'>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('insert.client') }}" method='POST'>
            @csrf
            <div class="row g-6">

                <!-- Client Name -->
                <div class="col-md-6">
                    <label class="form-label" for="client-name">Client Name</label>
                    <input type="text" id="client-name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="John Doe" value="{{ old('name') }}" />
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Client Email -->
                <div class="col-md-6">
                    <label class="form-label" for="client-email">Client Email</label>
                    <input type="email" id="client-email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="client@example.com" value="{{ old('email') }}" />
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Business Name -->
                <div class="col-md-6">
                    <label class="form-label" for="business-name">Business Name</label>
                    <input type="text" id="business-name" name="business_name"
                        class="form-control @error('business_name') is-invalid @enderror"
                        placeholder="Acme Corp" value="{{ old('business_name') }}" />
                    @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Client Country -->
                <div class="col-md-6">
                    <label class="form-label" for="client-country">Client Country</label>
                    <select name="country" class="form-select" required>
                        <option value="">-- Select Country --</option>
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Client Number -->
                <div class="col-md-6">
                    <label class="form-label" for="client-number">Client Number</label>
                    <input type="text" id="client-number" name="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror"
                        placeholder="+92 300 1234567" value="{{ old('phone_number') }}" />
                    @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Client Per Hour Charges -->
                <div class="col-md-6">
                    <label class="form-label" for="per-hour">Per Hour Charges</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input
                          type="number"
                          class="form-control @error('per_hour_charges') is-invalid @enderror""
                          placeholder="Amount"
                          name='per_hour_charges'
                          value="{{ old('per_hour_charges') }}"
                          aria-label="Amount (to the nearest dollar)" />
                        <span class="input-group-text">.00</span>
                      </div>
                    @error('per_hour_charges') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Select Timezone -->
                <div class="col-md-6">
                    <label class="form-label" for="timezone">Select Timezone</label>
                    <select id="timezone" name="timezone"
                            class="form-control @error('timezone') is-invalid @enderror">
                        <option value="">-- Select Timezone --</option>
                        @foreach(timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" {{ old('timezone') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                        @endforeach
                    </select>
                    @error('timezone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Contract Type -->
                <div class="col-md-6">
                    <label class="form-label" for="contract-type">Contract Type</label>
                    <select id="contract-type" name="contract_type_id"
                            class="form-control @error('contract_type_id') is-invalid @enderror">
                        <option value="">-- Select Contract Type --</option>
                        @foreach($contractTypes as $contractType)
                            <option value="{{ $contractType->id }}" {{ old('contract_type_id') == $contractType->id ? 'selected' : '' }}>
                                {{ $contractType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('contract_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Service -->
                <div class="col-md-6">
                    <label class="form-label" for="service">Service</label>
                    <select id="service" name="service_id"
                            class="form-control @error('service_id') is-invalid @enderror">
                        <option value="">-- Select Service --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Ring Center -->
                <div class="col-md-6">
                    <label class="form-label">Ring Center</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" id="ring-center" name="ring_center" value="1"
                            class="form-check-input" {{ old('ring_center') ? 'checked' : '' }}>
                        <label class="form-check-label" for="ring-center">Enable Ring Center</label>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary me-4">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>

            </div>

        </form>
    </div>
   </div>
</div>

@endsection
