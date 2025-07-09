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
                <h4 class="page-title mb-0 font-size-18">Product Inventory</h4>

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
        <div class="col-12">
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Product Inventory - <span style="font-size: 12px">{{$product->title}}</span></h4>
                    <form action="{{ route('admin.products.store-inventory') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="">
                                    <tr>
                                        <th style="width: 10%">Sr. No.</th>
                                        <th style="width: 50%">Size</th>
                                        <th style="width: 20%">Status</th>
                                        <th style="width: 20%">Stock In Hand</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr = 1;
                                    @endphp
                                    @if (count($product->productSizes) > 0)
                                        @forelse ($product->productSizes as $size)
                                            <tr>
                                                <td>{{$sr++}}</td>
                                                <td>
                                                    {{ $size->sizeData->size }}
                                                    <input type="hidden" name="inventoryItems[{{$size->size_id}}][size]" value="{{$size->sizeData->size}}">
                                                </td>
                                                <td>
                                                    <div class="form-group mt-2">
                                                        <select name="inventoryItems[{{$size->size_id}}][status]" class="form-control">
                                                            <option value="0" @if ($size->status == 0) @selected(true) @endif>Inactive</option>
                                                            <option value="1" @if ($size->status == 1) @selected(true) @endif>Active</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mt-2">
                                                        <input type="number" name="inventoryItems[{{$size->size_id}}][stock]" class="form-control"
                                                        placeholder="Stock" value="{{$size->stock}}" min="0">
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    @endif
                                    @forelse ($sizes as $size)
                                        <tr>
                                            <td>{{$sr++}}</td>
                                            <td>
                                                {{ $size->size }}
                                                <input type="hidden" name="inventoryItems[{{$size->id}}][size]" value="{{$size->size}}">
                                            </td>
                                            <td>
                                                <div class="form-group mt-2">
                                                    <select name="inventoryItems[{{$size->id}}][status]" class="form-control">
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group mt-2">
                                                    <input type="number" name="inventoryItems[{{$size->id}}][stock]" class="form-control"
                                                    placeholder="Current Stock" value="0" min="0">
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse 
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Save Inventory</button>
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
@endpush
