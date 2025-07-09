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
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Order leads</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Order Leads</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h4 class="card-title mb-4">Order Leads</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    {{-- <th>Customer ID</th> --}}
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Last Visited</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customerCarts as $cart)
                                    @isset($cart[0]->customer)
                                        @php
                                            $customer = $cart[0]->customer;
                                        @endphp
                                        <tr>
                                            {{-- <td>{{ $customer->id }}</td> --}}
                                            <td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->contact_number }}</td>
                                            <td>{{ $customer->last_visited_page }}</td>
                                            <td>
                                                <a href="{{ route('admin.customer-carts.edit', $customer->id) }}"
                                                    class="btn btn-warning btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endisset
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endpush
