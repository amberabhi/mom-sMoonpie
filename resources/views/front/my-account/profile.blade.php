@extends('layouts.front')
@section('title')
    Checkout | Moms Moonpie
@endsection
@section('style')
@endsection
@php
    $user = auth()->guard('customer')->user();
@endphp
@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container mt-5">
            <h2 class="comn-title-text mb-5 text-center">My <span>Profile</span></h2>
            <form action="{{ route('front.my-account.profile-update') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                    <h4>Customer Details</h4>
                                </div> --}}
                            <div class="card-body">
                                <b>Personal Information</b>
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">Firstname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            value="{{ $customer->firstname }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Lastname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            value="{{ $customer->lastname }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $customer->email }}" disabled required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_number" class="form-label">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact_number"
                                            value="{{ $customer->contact_number }}" name="contact_number" disabled required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping and Billing Address Section -->
                <div class="row mb-4">
                    <!-- Shipping Address -->
                    <div class="col-md-6">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Shipping Address</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Shipping Address</b>
                                <hr>
                                <div class="mb-3">
                                    <label for="shipping_street_address" class="form-label">Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_street_address"
                                        name="shipping_street_address" value="{{$customer->shipping_street_address}}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="shipping_state_id" class="form-label">State <span class="text-danger">*</span></label>
                                        <select class="form-control" id="shipping_state_id" name="shipping_state_id" required>
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" @if ($state->id == $customer->shipping_state_id) @selected(true) @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="shipping_city_id" class="form-label">City <span class="text-danger">*</span></label>
                                        <select class="form-control" id="shipping_city_id" name="shipping_city_id" required>
                                            <option value="">Select City</option>
                                            @foreach($shippingCities as $city)
                                                <option value="{{ $city->id }}" @if ($city->id == $customer->shipping_city_id) @selected(true) @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="shipping_postal_code" class="form-label">Zip Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="shipping_postal_code"
                                            name="shipping_postal_code" value="{{$customer->shipping_postal_code}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="col-md-6">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Billing Address</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Billing Address</b>
                                <hr>
                                <div class="mb-3">
                                    <label for="billing_street_address" class="form-label">Address
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="billing_street_address"
                                        name="billing_street_address" value="{{$customer->billing_street_address}}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="billing_state_id" class="form-label">State <span class="text-danger">*</span></label>
                                        <select class="form-control" id="billing_state_id" name="billing_state_id" required>
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" @if ($state->id == $customer->billing_state_id) @selected(true) @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="billing_city_id" class="form-label">City <span class="text-danger">*</span></label>
                                        <select class="form-control" id="billing_city_id" name="billing_city_id" required>
                                            <option value="">Select City</option>
                                            @foreach($billingCities as $city)
                                                <option value="{{ $city->id }}" @if ($city->id == $customer->billing_city_id) @selected(true) @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label for="billing_postal_code" class="form-label">Zip Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="billing_postal_code"
                                            name="billing_postal_code" value="{{$customer->billing_postal_code}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2">
                        <button type="submit" style="background-color:#0e0132"
                            class="btn btn-primary btn-lg w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
<script>
    // When state changes, fetch the corresponding cities
    $('#shipping_state_id').change(function() {
        var stateId = $(this).val(); // Get the selected state ID

        if(stateId) {
            $.ajax({
                url: '{{route('front.my-account.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
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
                url: '{{route('front.my-account.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
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
@endsection
