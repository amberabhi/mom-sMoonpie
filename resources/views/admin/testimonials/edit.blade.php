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
                <h4 class="page-title mb-0 font-size-18">Testimonial</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Testimonial</a></li>
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
                    <h4 class="card-title mb-4">Edit Testimonial</h4>
                    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial->id) }}"
                        class="row g-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $testimonial->title }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status2" class="form-label">Status {!! $required_span !!}</label>
                            <select id="status2" name="status" class="form-control" required>
                                <option value="1" @if ($testimonial->status == 1) @selected(true) @endif>Active</option>
                                <option value="0" @if ($testimonial->status == 0) @selected(true) @endif>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Customer Name {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="{{ $testimonial->customer_name }}" required>
                            @error('customer_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            @php
                                $ratingArray = [1, 2, 3, 4, 5];
                            @endphp
                            <label for="rating" class="form-label">Rating {!! $required_span !!}</label>
                            <select id="rating" name="rating" class="form-control" required>
                                @foreach ($ratingArray as $rating)
                                    <option value="{{$rating}}" @if ($testimonial->rating == $rating) @selected(true) @endif>{{$rating}}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="review">Review {!! $required_span !!}</label>
                                <textarea name="review" class="form-control" id="review" rows="4" placeholder="">{{ $testimonial->review }}</textarea>
                                @error('review')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Image {!! $required_span !!}</label>
                                <div class="m-3">
                                    <img src="{{ url('images/testimonial') }}/{{$testimonial->image}}" alt="image" height="75px" width="75px">
                                </div>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-dark">Back</a>
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
