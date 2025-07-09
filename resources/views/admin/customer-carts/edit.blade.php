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
                <h4 class="page-title mb-0 font-size-18">Order Leads</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customer Cart</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Customer Cart - {{$customer->firstname}} {{$customer->lastname}}</h4> --}}
                    <div class="row g-1">
                        <div class="col-md-4 mb-2">
                            Customer Name : {{$customer->firstname}} {{$customer->lastname}}
                        </div>
                        <div class="col-md-4 mb-2">
                            Contact No. : {{$customer->contact_number}}
                        </div>
                        <div class="col-md-4 mb-2">
                            Email : {{$customer->email}}
                        </div>
                        
                        @if ($customer->last_visited_page)
                            Last Visited : {{ $customer->last_visited_page }}
                        @endif
                    </div>
                    <hr>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Added at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            @php
                                                $productImage = $item->product->productImages->first()->image_path ?? asset('images/shopping-bag.webp');
                                            @endphp
                                            <tr>
                                                <td><img src="{{ asset('images/product-image/' . $productImage) }}"
                                                    alt="Product Image" width="60"></td>
                                                <td>
                                                    {{ $item->product->title }}  <br>
                                                    @if (isset($item->productSize->size))
                                                        <b style="font-size: 12px;">Size : {{ $item->productSize->size }}</b>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
