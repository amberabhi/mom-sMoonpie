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
            {{-- <h2 class="mb-4 text-center" style="color: #DE2976;">Checkout</h2> --}}
            <h2 class="comn-title-text mb-5 text-center"> <span>Checkout</span></h2>
            <form action="{{ route('front.phonepay.pay') }}" method="POST">
			{{-- <form action="{{ route('front.checkout.submit') }}" method="POST"> --}}
                @csrf
                <div class="row mb-4">
                    <!-- Customer Details -->
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Customer Details</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Customer Details</b>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">Firstname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Lastname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            value="{{ $user->lastname }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" readonly class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_number" class="form-label">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact_number"
                                            value="{{ $user->contact_number }}" name="contact_number" required>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping and Billing Address Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" _class="form-check-input" id="address_same" name="address_same"
                                    onchange="copyAddress()">
                                <label for="address_same" class="form-check-label">Billing address same as shipping address?
                                    <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
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
                                            name="shipping_postal_code" value="{{$customer->shipping_postal_code}}"  required>
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
                                            name="billing_postal_code" value="{{$customer->billing_postal_code}}"  required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart and Payment Summary Section -->
                <div class="row">
                    <!-- Cart Details -->
                    <div class="col-md-8">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Your Cart</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Order Items</b>
                                <hr>
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $srNo = 1;
                                            $subTotal = 0;
                                            $taxAmount = 0;
                                        @endphp
                                        @forelse ($cart as $item)
                                            @php
                                                $itemTotal =  $item->price * $item->quantity;
                                                $taxPercentage = ($item->price <= 1000) ? ($settings->tax_below_1k ?? 0) :  ($settings->tax_above_1k ?? 0);  
                                                $taxAmount += ($itemTotal * $taxPercentage) / 100;
                                                $subTotal += $itemTotal;
                                                $productImage = $item->product->productImages->first()->image_path ?? asset('images/shopping-bag.webp');
                                            @endphp
                                            <tr>
                                                <td>{{ $srNo++ }}</td>
                                                <td><img src="{{ asset('images/product-image/' . $productImage) }}"
                                                        alt="{{ $item->product->title }}" width="60"></td>
                                                <td style="text-align: left;">
                                                    {{ $item->product->title }} <br>
                                                    @if (isset($item->productSize->size))
                                                        <b style="font-size: 12px;">Size : {{ $item->productSize->size }}</b>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					@php
						$shippingAmount = $settings->shipping_charge ?? 0;
                        $grandTotal = $subTotal + $shippingAmount + $taxAmount;
					@endphp
					<!-- Payment Summary -->
                    <div class="col-md-4">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Payment Summary</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Apply Discount</b>
                                <hr>
                                <div class="row">
                                    <div class="col-md-9 mb-3 mt-2">
                                        <input type="text" class="form-control" id="promocode"
                                            name="promocode" placeholder="Enter Promocode">
                                        <p id="promo-error" class="text-danger mt-1" style="font-size: 13px"></p>
                                        <p id="promo-success" class="text-success" style="font-size: 13px"></p>
                                    </div>
                                    <div class="col-md-3 mb-3 mt-2">
                                        <button type="button" class="btn btn-primary" onclick="applyPromocode()">Apply</button>
                                    </div>
                                </div>
                                <hr>

                                <b>Payment Summary</b>
                                <hr>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Subtotal</span>
                                        <strong>{{ number_format($subTotal, 2) }}</strong>
                                        <input type="hidden" id="subtotal" name="subtotal" value="{{ $subTotal }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Shipping</span>
                                        <strong>{{ number_format($shippingAmount, 2) }}</strong>
                                        <input type="hidden" id="shipping_charge" name="shipping_charge" value="{{ $shippingAmount }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Tax</span>
                                        <strong>{{ number_format($taxAmount, 2) }}</strong>
                                        <input type="hidden" id="tax_amount" name="tax_amount" value="{{ $taxAmount }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Discount</span>
                                        <strong id="discount_amount_text">0.00</strong>
                                        <input type="hidden" id="discount_amount" name="discount_amount" value="0.00">
                                        <input type="hidden" name="promocode_id" id="promocode_id">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Grand Total</strong>
                                        <strong id="total_amount_text">{{ number_format($grandTotal, 2) }}</strong>
                                        <input type="hidden" id="total_amount" name="total_amount" value="{{ $subTotal }}">
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" style="background-color:#0e0132"
                                    class="btn btn-primary btn-lg w-100">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
<script>
    var applyPromocodeUrl =  "{{ route('front.checkout.apply-promocode') }}";
</script>
<script>
    // When state changes, fetch the corresponding cities
    $('#shipping_state_id').change(function() {
        var stateId = $(this).val(); // Get the selected state ID

        if(stateId) {
            $.ajax({
                url: '{{route('front.checkout.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
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
                url: '{{route('front.checkout.get-cities', '')}}/' + stateId, // URL to fetch cities based on state
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
