@extends('layouts.front')
@section('style')
<style>
    .cart-wishlist-btn {
        margin-top: 70%;
        width: 18px;
        height: 18px;
        background-color: transparent;
        padding: 0;
        border: none;
        font-size: 18px;
        color: var(--primary-color);
    }
</style>
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Your <span>Cart</span></h2>
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
				@if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
				@if (session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif
                @if(!$cart->count())
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h4>Your cart is empty! <a href="{{ route('front.product-list') }}">Shop now</a></h4>
                                </center>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-8">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Your Cart</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Cart Items</b>
                                <hr>
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            {{-- <th>Sr.</th> --}}
                                            <th>Image</th>
                                            <th>Product Title</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Action</th>
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
                                                <td>
                                                    <button class="cart-wishlist-btn" data-product-id="{{ $item->id }}">
                                                        <i class="{{ auth()->guard('customer')->check() && $item->product->isInCustomerWishlist() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                    </button>
                                                </td>
                                                {{-- <td>{{ $srNo++ }}</td> --}}
                                                <td><img src="{{ asset('images/product-image/' . $productImage) }}"
                                                        alt="Product Image" width="60"></td>
                                                <td>
                                                    {{ $item->product->title }}  <br>
                                                    @if (isset($item->productSize->size))
                                                        <b style="font-size: 12px;">Size : {{ $item->productSize->size }}</b>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>
                                                    <form action="" method="POST" class="d-flex align-items-center">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <input type="number" name="quantity" onkeyup="updateCart('{{ $item->id }}', this.value)" onchange="updateCart('{{ $item->id }}', this.value)"
                                                            value="{{ $item->quantity }}" min="1"  class="form-control quantity-input">
                                                        {{-- <button type="button" class="btn btn-secondary ms-2">Update</button> --}}
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('front.cart.remove-item') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <button type="submit" class="btn btn-danger"><i class='fas fa-trash-alt'></i></button>
                                                    </form>
                                                </td>
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
                                <b>Payment Summary</b>
                                <hr>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Subtotal</span>
                                        <strong>{{ number_format($subTotal, 2) }}</strong>
                                        <input type="hidden" name="subtotal" value="{{ $subTotal }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Shipping</span>
                                        <strong>{{ number_format($shippingAmount, 2) }}</strong>
                                        <input type="hidden" name="shipping_charge" value="{{ $shippingAmount }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Tax</span>
                                        <strong>{{ number_format($taxAmount, 2) }}</strong>
                                        <input type="hidden" name="tax_amount" value="{{ $taxAmount }}">
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Grand Total</strong>
                                        <strong>{{ number_format($grandTotal, 2) }}</strong>
                                        <input type="hidden" name="total_amount" value="{{ $subTotal }}">
                                    </li>
                                </ul>
                            </div>
                            @if (count($cart) > 0)
                                <div class="card-footer text-end">
                                    <a href="{{ route('front.checkout.index') }}" style="background-color:#0e0132"
                                        class="btn btn-success btn-lg w-100">Start
                                        Checkout</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
    <script>
        var updateCartUrl = "{{ route('front.cart.update') }}";
    </script>
@endsection
