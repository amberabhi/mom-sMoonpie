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
                <h4 class="page-title mb-0 font-size-18">Order #{{ $order->id }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Order</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Details</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Order Number :</b> #{{ $order->id }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Order Date :</b> {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Order Status :</b> {{ $order->order_status }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Payment Status :</b> {{ $order->payment_status }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Payment Method :</b> {{ $order->payment_method }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Order Total :</b> {{ $order->total_amount }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Details</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Customer Name :</b> {{ $order->firstname }} {{ $order->lastname }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Email :</b> {{ $order->email }} </p>
                            </div>
                            <div class="col-md-12">
                                <p><b>Contact No. :</b> {{ $order->contact_number }} </p>
                            </div>
                            <div class="col-md-12">
                                <b>Billing Address</b>
                                <p>
                                    {{ $order->billing_street_address }},
                                    {{ $order->billing_city }}, {{ $order->billing_state }},
                                    {{ $order->billing_country }}, {{ $order->billing_postal_code }}.
                                </p>
                            </div>
                            <div class="col-md-12">
                                <b>Shipping Address</b>
                                <p>
                                    {{ $order->shipping_street_address }},
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }},
                                    {{ $order->shipping_country }}, {{ $order->shipping_postal_code }}.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Items</h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Product Type</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $srNo = 1;
                                    @endphp
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $srNo++ }}</td>
                                            <td>
                                                <img src="{{ url('images/product-image') }}/{{ $item->product->productImages->first()->image_path ?? '' }}"
                                                    style="max-width: 80px" alt="">
                                            </td>
                                            <td>
                                                {{ $item->product->title }} <br>
                                                @if (isset($item->size->size))
                                                    <b style="font-size: 12px">{{$item->size->size}}</b>
                                                @endif
                                            </td>
                                            <td>{{ $item->product->productType->title }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <p style="text-align: right"><b>Subtotal</b> : {{ $order->subtotal }}</p>
                                <p style="text-align: right"><b>Tax</b> : {{ $order->tax_amount }}</p>
                                <p style="text-align: right"><b>Shipping</b> : {{ $order->shipping_charge }}</p>
                                <p style="text-align: right"><b>Discount</b> : {{ $order->discount_amount }}</p>
                                <p style="text-align: right"><b>Grand Total</b> : {{ $order->total_amount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statuses</h4>
                        <hr>
                        @php
                            $orderStatuses = ['Pending', 'Confirmed', 'Cancelled', 'Shipped', 'Delivered', 'Completed'];
                            $paymentStatuses = ['Unpaid', 'Paid'];
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <label for="order_status" class="form-label">Order Status</label>
                                <select class="form-select" id="order_status" name="order_status">
                                    @forelse ($orderStatuses as $status)
                                        <option value="{{ $status }}"
                                            @if ($order->order_status == $status) @selected(true) @endif>
                                            {{ $status }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-select" id="payment_status" name="payment_status">
                                    @forelse ($paymentStatuses as $status)
                                        <option value="{{ $status }}"
                                            @if ($order->payment_status == $status) @selected(true) @endif>
                                            {{ $status }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">Cancel</a>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('script')
    
@endpush
