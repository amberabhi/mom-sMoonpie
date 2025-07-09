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
                <h4 class="page-title mb-0 font-size-18">Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
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
                    <form method="POST" action="{{ route('admin.settings.store') }}" class="row"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-3">
                            <label for="tax_below_1k" class="form-label">Tax (Below 1K) {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="tax_below_1k" name="tax_below_1k"
                                value="{{ $settings->tax_below_1k }}" required>
                            @error('tax_below_1k')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tax_above_1k" class="form-label">Tax (Above 1K) {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="tax_above_1k" name="tax_above_1k"
                                value="{{ $settings->tax_above_1k }}" required>
                            @error('tax_above_1k')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipping_charge" class="form-label">Shipping Charge {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="shipping_charge" name="shipping_charge"
                                value="{{ $settings->shipping_charge }}" required>
                            @error('shipping_charge')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
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
