@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Your <span>Orders</span></h2>
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @empty($orders)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h4>There's no order! <a href="{{ route('front.product-list') }}">Shop now</a></h4>
                                </center>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Your Cart</h4>
                            </div> --}}
                            <div class="card-body">
                                {{-- <b>Cart Items</b>
                                <hr> --}}
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Order No.</th>
                                            <th>Date</th>
                                            <th>Shipment Status</th>
                                            <th>Payment Method</th>
                                            <th>Total Amount</th>
                                            <th>Invoice</th>
                                            <th>Shipping</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ explode(' ', $order->created_at)[0] }}</td>
                                                <td>{{ $order->shipment_status }}</td>
                                                <td>{{ $order->payment_method }}</td>
                                                <td>{{ $order->total_amount }}</td>
                                                <td>
                                                    {{-- <a href=""><i class='fas fa-eye' style='font-size:20px'></i></a> --}}
                                                    <a href="{{ route('front.my-account.order-invoice', $order->id) }}"
                                                        style="margin-left: 5px;"><i class='fas fa-file-invoice text-danger'
                                                            style='font-size:20px'></i></a>
                                                </td>
                                                <td> @empty(!$order->shiprocket_order_id) <a href="{{ route('front.my-account.order-tracking',$order->shiprocket_order_id) }}">Track</a> @else - @endempty</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endempty
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
