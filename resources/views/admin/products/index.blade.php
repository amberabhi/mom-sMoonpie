@extends('layouts.admin-master')
@section('title')
    Dashbaord
@endsection
@push('css')
    <!-- jquery.vectormap css -->
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />
	<!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Products</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">List</li>
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
                    <div class="col-12 mb-3">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-dark">Add Product</a>
                    </div>
                    <h4 class="card-title mb-4">List Products</h4>
                    <!-- Product Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="productsTable">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <!-- <th>Brand</th> -->
                                    <th>Title</th>
                                    <!-- <th>Product Type</th> -->
                                    <th>Color</th>
                                    <th>Age Group</th>
                                    <!-- <th>L X B</th>
                                    <th>L X B X H</th> -->
                                    <th>Weight</th>
                                    {{-- <th>Quantity</th> --}}
                                    <th>Units Available</th>
                                    <th>MRP</th>
                                    <!-- <th>Discount</th> -->
                                    <th>Net Price</th>
                                    <th>Description</th>
                                    <!-- <th>Material</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->sku }}</td>
                                        {{-- <td>{{ $product->brand }}</td> --}}
                                        <td>{{ substr($product->title, 0, 25) }}</td>
                                        {{-- <td>{{ $product->product_type }}</td> --}}
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->age_group }}</td>
                                        <!-- <td>{{ $product->lb }}</td>
                                        <td>{{ $product->lbh }}</td> -->
                                        <td>{{ $product->weight }}</td>
                                        {{-- <td>{{ $product->quantity }}</td> --}}
                                        <td>{{ $product->units_available }}</td>
                                        <td>{{ $product->mrp }}</td>
                                        <!-- <td>{{ $product->discount }}</td> -->
                                        <td>{{ $product->net_price }}</td>
                                        <td>{{ Str::limit($product->description, 100, '...') }}</td>
                                        {{-- <td>{{ $product->material }}</td> --}}
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <!-- Add a delete button or form if needed -->
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                            </form>
                                            <a href="{{ route('admin.products.inventory', $product->id) }}"
                                                class="btn btn-success btn-sm">Inventory</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    {{-- {{ $products->links() }} --}}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

	<!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

	<script>
		$(document).ready(function () {
			$('#productsTable').DataTable({
				serverSide: false,
			});
		});
    </script>
@endpush
