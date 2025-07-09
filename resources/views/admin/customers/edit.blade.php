@extends('layouts.admin-master')
@section('title')
    Dashbaord
@endsection
@push('css')
    <!-- jquery.vectormap css -->
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@section('content')
    @php
        $required_span = '<span class="text-danger">*</span>';
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Customers</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customers</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Customer - {{$customer->firstname}} {{$customer->lastname}}</h4>
                    <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}"
                        class="row g-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <b>Personal Information</b>
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Firstname {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                value="{{ $customer->firstname }}" @required(true)>
                            @error('firstname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Lastname {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                value="{{ $customer->lastname }}" @required(true)>
                            @error('lastname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email {!! $required_span !!}</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $customer->email }}" @required(true)>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact Number {!! $required_span !!}</label>
                            <input type="number" class="form-control" id="contact_number" name="contact_number"
                                value="{{ $customer->contact_number }}" @required(true)>
                            @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <b>Shipping Address</b>
                        <div class="col-md-12">
                            <label for="shipping_street_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="shipping_street_address" name="shipping_street_address" value="{{$customer->shipping_street_address}}" required>
                            @error('shipping_street_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_state_id" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-control" id="shipping_state_id" name="shipping_state_id" required>
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" @if ($state->id == $customer->shipping_state_id) @selected(true) @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('shipping_state_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control" id="shipping_city_id" name="shipping_city_id" required>
                                <option value="">Select City</option>
                                @foreach($shippingCities as $city)
                                    <option value="{{ $city->id }}" @if ($city->id == $customer->shipping_city_id) @selected(true) @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('shipping_city_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_postal_code" class="form-label">Zip Code <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="shipping_postal_code"
                                name="shipping_postal_code" value="{{$customer->shipping_postal_code}}"  required>
                            @error('shipping_postal_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <b>Billing Address</b>
                        <div class="col-md-12">
                            <label for="billing_street_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="billing_street_address" name="billing_street_address" value="{{$customer->billing_street_address}}" required>
                            @error('billing_street_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="billing_state_id" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-control" id="billing_state_id" name="billing_state_id" required>
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" @if ($state->id == $customer->billing_state_id) @selected(true) @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('billing_state_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="billing_city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-control" id="billing_city_id" name="billing_city_id" required>
                                <option value="">Select City</option>
                                @foreach($billingCities as $city)
                                    <option value="{{ $city->id }}" @if ($city->id == $customer->billing_city_id) @selected(true) @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('billing_city_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="billing_postal_code" class="form-label">Zip Code <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="billing_postal_code"
                                name="billing_postal_code" value="{{$customer->billing_postal_code}}"  required>
                            @error('billing_postal_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status {!! $required_span !!}</label>
                            <select id="status2" name="status" class="form-select" @required(true)>
                                <option value="">Please Select</option>
                                <option value="1" @if ($customer->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($customer->status == 0) selected @endif>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-dark">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // When state changes, fetch the corresponding cities
        $('#shipping_state_id').change(function() {
            var stateId = $(this).val(); // Get the selected state ID

            if(stateId) {
                $.ajax({
                    url: '{{route('admin.customers.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
                    method: 'GET',
                    success: function(response) {
                        $('#shipping_city_id').empty(); // Clear existing options
                        $('#shipping_city_id').append('<option value="">Select City</option>');
                        response.cities.forEach(function(city) {
                            $('#shipping_city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            } else {
                $('#shipping_city_id').empty();
                $('#shipping_city_id').append('<option value="">Select City</option>');
            }
        });

        $('#billing_state_id').change(function() {
            var stateId = $(this).val(); // Get the selected state ID

            if(stateId) {
                $.ajax({
                    url: '{{route('admin.customers.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
                    method: 'GET',
                    success: function(response) {
                        $('#billing_city_id').empty(); // Clear existing options
                        $('#billing_city_id').append('<option value="">Select City</option>');
                        response.cities.forEach(function(city) {
                            $('#billing_city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            } else {
                $('#billing_city_id').empty();
                $('#billing_city_id').append('<option value="">Select City</option>');
            }
        });
    </script>
@endpush
