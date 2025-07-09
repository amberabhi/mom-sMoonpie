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
                <h4 class="page-title mb-0 font-size-18">Products</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Product</h4>
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="product_status"
                                        name="status" value="1" checked>
                                    <label class="form-check-label" for="status">Disabled / Enabled </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_new_collection"
                                        name="is_new_collection" value="1" checked>
                                    <label class="form-check-label" for="is_new_collection">New Collection</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_trending"
                                        name="is_trending" value="1">
                                    <label class="form-check-label" for="is_trending">Trending Product </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_in_stock"
                                        name="is_in_stock" value="1">
                                    <label class="form-check-label" for="is_in_stock">In Stock </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <label for="title">Title {!! $required_span !!}</label>
                            <input type="text" name="title" class="form-control" id="title"
                                placeholder="Enter Title" value="{{ old('title') }}" required onchange="createSlug(this.value)">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="slug">Slug {!! $required_span !!}</label>
                            <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter slug"
                                value="{{ old('slug') }}" required>
                            @error('slug')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="sku">SKU {!! $required_span !!}</label>
                            <input type="text" name="sku" class="form-control" id="sku" placeholder="Enter SKU"
                                value="{{ old('sku') }}" required>
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nav_category" class="form-label">Choose Category</label>
                            <select class="form-control select2" id="nav_category" name="nav_category[]" multiple>
                                <option value="" disabled>-- Select an Option --</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        @error('nav_category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        {{-- <div class="form-group mt-2">
                            <label for="brand">Brand {!! $required_span !!}</label>
                            <input type="text" name="brand" class="form-control" id="brand"
                                placeholder="Enter Brand" value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="product_type">Product Type {!! $required_span !!}</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="">Select Product Type</option>
                                @forelse ($productTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('product_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="product_sizes">Product Size {!! $required_span !!}</label>
                            <select name="product_sizes[]" id="product_sizes" class="form-control" required multiple>
                                @forelse ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('product_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="color">Color {!! $required_span !!}</label>
                            <input type="text" name="color" class="form-control" id="color"
                                placeholder="Enter Color" value="{{ old('color') }}" required>
                            @error('color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="age_group">Age Group {!! $required_span !!}</label>
                            <input type="text" name="age_group" class="form-control" id="age_group"
                                placeholder="Enter Age Group" value="{{ old('age_group') }}" required>
                            @error('age_group')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- <div class="form-group mt-2">
                            <label for="lb">Dimensions (L X B) {!! $required_span !!}</label>
                            <input type="text" name="lb" class="form-control" id="lb"
                                placeholder="Enter Dimensions (L X B)" value="{{ old('lb') }}" required>
                            @error('lb')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="lbh">Dimensions (L X B X H) {!! $required_span !!}</label>
                            <input type="text" name="lbh" class="form-control" id="lbh"
                                placeholder="Enter Dimensions (L X B X H)" value="{{ old('lbh') }}" required>
                            @error('lbh')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="weight">Weight {!! $required_span !!}</label>
                            <input type="number" name="weight" class="form-control" id="weight" placeholder="Enter Weight" value="{{ old('weight') }}" required>
                            @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="quantity">Quantity {!! $required_span !!}</label>
                            <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="units_available">Units Available {!! $required_span !!}</label>
                            <input type="number" name="units_available" class="form-control" id="units_available"
                                placeholder="Enter Units Available" value="{{ old('units_available') }}" required>
                            @error('units_available')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="mrp">MRP {!! $required_span !!}</label>
                            <input type="number" name="mrp" class="form-control" id="mrp"
                                placeholder="Enter MRP" value="{{ old('mrp') }}" required>
                            @error('mrp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="discount">Discount {!! $required_span !!}</label>
                            <input type="number" name="discount" class="form-control" id="discount"
                                placeholder="Enter Discount" value="{{ old('discount') }}">
                            @error('discount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="net_price">Net Price {!! $required_span !!}</label>
                            <input type="number" name="net_price" class="form-control" id="net_price"
                                placeholder="Enter Net Price" value="{{ old('net_price') }}" required>
                            @error('net_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="description">Description {!! $required_span !!}</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Enter Description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="material">Material {!! $required_span !!}</label>
                            <input type="text" name="material" class="form-control" id="material"
                                placeholder="Enter Material" value="{{ old('material') }}" required>
                            @error('material')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="is_sizes_available"> Is size available ? {!! $required_span !!}</label>
                            <select name="is_size_available" id="is_size_available" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_size_available')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="product_images" class="form-label">Images {!! $required_span !!}</label>
                            <input type="file" class="form-control" id="product_images" name="product_images[]"
                                accept="image/*" multiple required>
                            @error('product_images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Create Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-4">Cancel</a>
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
	<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $('.select2').select2({
            allowClear: false
        });
        
        function createSlug(text) {
            const slug = text
                .toLowerCase() // Convert to lowercase
                .replace(/[|&;$%@"<>()+,']/g, '') // Remove special characters including apostrophes
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens with a single hyphen
                .replace(/^-|-$/g, ''); // Remove leading and trailing hyphens

            $('#slug').val(slug); // Set the processed slug to the input field
            return slug;
        }

        $(document).ready(function() {
            $('#title').on('input', function() {
                const title = $(this).val();
                createSlug(title);
            });
			
			CKEDITOR.replace('description');
			
        });
    </script>
@endpush
