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
                    <h4 class="card-title mb-4">Edit Product</h4>
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="product_status"
                                        name="status" value="1"
                                        @if ($product->status == 1) @checked(true) @endif>
                                    <label class="form-check-label" for="product_status">Disabled / Enabled </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_new_collection"
                                        name="is_new_collection" value="1"
                                        @if ($product->is_new_collection == 1) @checked(true) @endif>
                                    <label class="form-check-label" for="is_new_collection">New Collection</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_trending"
                                        name="is_trending" value="1"
                                        @if ($product->is_trending == 1) @checked(true) @endif>
                                    <label class="form-check-label" for="is_trending">Trending Product </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_in_stock"
                                        name="is_in_stock" value="1"
                                        @if ($product->is_in_stock == 1) @checked(true) @endif>
                                    <label class="form-check-label" for="is_in_stock">In Stock </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <label for="title">Title {!! $required_span !!}</label>
                            <input type="text" name="title" class="form-control" id="title"
                                placeholder="Enter Title" value="{{ old('title', $product->title) }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="slug">Slug {!! $required_span !!}</label>
                            <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter slug"
                                value="{{ old('slug', $product->slug) }}" required>
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="sku">SKU {!! $required_span !!}</label>
                            <input type="text" name="sku" class="form-control" id="sku" placeholder="Enter SKU"
                                value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nav_category" class="form-label">Choose Category</label>
                            <select class="form-select select2" id="nav_category" name="nav_category[]" multiple>
                                <option value=""  disabled>-- Select an Option --</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}" @if (in_array($category->id, $productCategories)) @selected(true) @endif>{{ $category->name }}</option>
                                @empty
                                @endforelse
                                {{-- <option value="just-in-499" @selected($product->nav_category == 'just-in-499')>Just in 499</option>
                                <option value="shop-for-boys" @selected($product->nav_category == 'shop-for-boys')>Shop for Boys</option>
                                <option value="shop-for-girls" @selected($product->nav_category == 'shop-for-girls')>Shop for Girls</option>
                                <option value="shop-for-infants" @selected($product->nav_category == 'shop-for-infants')>Shop for Infants</option>
                                <option value="gifting" @selected($product->nav_category == 'gifting')>Gifting</option> --}}
                            </select>
                            @error('nav_category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="brand">Brand {!! $required_span !!}</label>
                            <input type="text" name="brand" class="form-control" id="brand"
                                placeholder="Enter Brand" value="{{ old('brand', $product->brand) }}" required>
                            @error('brand')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="product_type">Product Type {!! $required_span !!}</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="">Select Product Type</option>
                                @forelse ($productTypes as $type)
                                    <option value="{{ $type->id }}"
                                        @if ($type->id == $product->product_type) @selected(true) @endif>
                                        {{ $type->title }}</option>
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
                                    <option value="{{ $size->id }}" @if (in_array($size->id, $productSizes)) @selected(true) @endif>{{ $size->size }}</option>
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
                                placeholder="Enter Color" value="{{ old('color', $product->color) }}" required>
                            @error('color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="age_group">Age Group {!! $required_span !!}</label>
                            <input type="text" name="age_group" class="form-control" id="age_group"
                                placeholder="Enter Age Group" value="{{ old('age_group', $product->age_group) }}"
                                required>
                            @error('age_group')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- <div class="form-group mt-2">
                            <label for="lb">Dimensions (L X B) {!! $required_span !!}</label>
                            <input type="text" name="lb" class="form-control" id="lb"
                                placeholder="Enter Dimensions (L X B)" value="{{ old('lb', $product->lb) }}" required>
                            @error('lb')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="lbh">Dimensions (L X B X H) {!! $required_span !!}</label>
                            <input type="text" name="lbh" class="form-control" id="lbh"
                                placeholder="Enter Dimensions (L X B X H)" value="{{ old('lbh', $product->lbh) }}"
                                required>
                            @error('lbh')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="weight">Weight {!! $required_span !!}</label>
                            <input type="number" name="weight" class="form-control" id="weight"
                                placeholder="Enter Weight" value="{{ old('weight', $product->weight) }}" required>
                            @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="quantity">Quantity {!! $required_span !!}</label>
                            <input type="text" name="quantity" class="form-control" id="quantity"
                                placeholder="Enter Quantity" value="{{ old('quantity', $product->quantity) }}" required>
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-group mt-2">
                            <label for="units_available">Units Available {!! $required_span !!}</label>
                            <input type="number" name="units_available" class="form-control" id="units_available"
                                placeholder="Enter Units Available"
                                value="{{ old('units_available', $product->units_available) }}" required>
                            @error('units_available')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-2">
                            <label for="mrp">MRP {!! $required_span !!}</label>
                            <input type="number" name="mrp" class="form-control" id="mrp"
                                placeholder="Enter MRP" value="{{ old('mrp', $product->mrp) }}" required>
                            @error('mrp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="discount">Discount {!! $required_span !!}</label>
                            <input type="number" name="discount" class="form-control" id="discount"
                                placeholder="Enter Discount" value="{{ old('discount', $product->discount) }}">
                            @error('discount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="net_price">Net Price {!! $required_span !!}</label>
                            <input type="number" name="net_price" class="form-control" id="net_price"
                                placeholder="Enter Net Price" value="{{ old('net_price', $product->net_price) }}"
                                required>
                            @error('net_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="description">Description {!! $required_span !!}</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Enter Description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="material">Material {!! $required_span !!}</label>
                            <input type="text" name="material" class="form-control" id="material"
                                placeholder="Enter Material" value="{{ old('material', $product->material) }}" required>
                            @error('material')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="is_sizes_available"> Is size available ? {!! $required_span !!}</label>
                            <select name="is_size_available" id="is_size_available" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="1" @if ($product->is_size_available == 1) @selected(true) @endif>Yes</option>
                                <option value="0" @if ($product->is_size_available == 0) @selected(true) @endif>No</option>
                            </select>
                            @error('is_size_available')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group mt-2">
                            <label for="product_images" class="form-label">Images {!! $required_span !!}</label>
                            <input type="file" class="form-control" id="product_images" name="product_images[]"
                                accept="image/*" multiple>
                            @error('product_images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mt-2">
                            @forelse ($productImages as $image)
                                <div class="col-md-2 mt-4">
                                    <img src="{{ url('images/product-image') }}/{{ $image->image_path }}"
                                        alt="Product Image" class="defaultGlightbox glightbox-content m-1" height="100"
                                        width="125" style="border-radius: 5%; border:1px solid black">
                                    <div class="text-center">
                                        @if ($image->is_default == 0)
                                            <a href="{{ route('admin.products.set-default-image', $image->id) }}"
                                                class="bs-tooltip text-success" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Set as Default"
                                                data-original-title="Set as Default"
                                                onclick="return confirm('Are you sure to set this image as default image ?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-check-circle">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                </svg>
                                            </a>
                                            <span class="ml-2 mr-2"> | </span>

                                            <a href="{{ route('admin.products.remove-image', $image->id) }}"
                                                class="bs-tooltip text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Remove Image"
                                                data-original-title="Remove Image"
                                                onclick="return confirm('Are you sure to delete this image ?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 ">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </a>
                                        @else
                                            <p class="text-primary">Default Image</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
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
			CKEDITOR.replace('description'); // CK Editor
        });
    </script>
@endpush
