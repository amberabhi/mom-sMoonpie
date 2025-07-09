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
                    <h4 class="card-title mb-4">Edit Banner</h4>
                    <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}"
                        class="row g-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Title {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $banner->title }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="description">Description {!! $required_span !!}</label>
                                <textarea name="description" class="form-control" id="description" rows="4" placeholder="">{{ $banner->description }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cta_text" class="form-label">Call to action Text {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="cta_text" name="cta_text"
                                value="{{ $banner->cta_text }}" required>
                            @error('cta_text')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-9 mb-3">
                            <label for="cta_url" class="form-label">Call to action URL {!! $required_span !!}</label>
                            <input type="text" class="form-control" id="cta_url" name="cta_url"
                                value="{{ $banner->cta_url }}" required>
                            @error('cta_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_1" class="form-label">Image 1 {!! $required_span !!}</label>
                                <div class="m-3">
                                    <img src="{{ url('images/banner') }}/{{$banner->image_1}}" alt="image" height="75px" width="75px">
                                </div>
                                <input type="file" class="form-control" id="image_1" name="image_1"
                                    accept="image/*">
                                @error('image_1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image_2" class="form-label">Image 2 {!! $required_span !!}</label>
                                <div class="m-3">
                                    <img src="{{ url('images/banner') }}/{{$banner->image_2}}" alt="image" height="75px" width="75px">
                                </div>
                                <input type="file" class="form-control" id="image_2" name="image_2"
                                    accept="image/*">
                                @error('image_2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status2" class="form-label">Status {!! $required_span !!}</label>
                            <select id="status2" name="status" class="form-control" required>
                                <option value="1" @if ($banner->status == 1) @selected(true) @endif>Active</option>
                                <option value="0" @if ($banner->status == 0) @selected(true) @endif>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-dark">Back</a>
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
