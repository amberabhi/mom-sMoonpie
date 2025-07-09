@extends('layouts.front')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-picZoomer.css') }}">
    <style>
		/*
        .cart-wishlist-btn {
            margin-left: 2%;
            width: 18px;
            height: 18px;
            background-color: transparent;
            padding: 0;
            border: none;
            font-size: 18px;
            color: var(--primary-color);
        }
		*/
    </style>
@endsection
@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center picZoomer">
                        @php
                            $obj = $product->productImages ?? [];

                            $images = !empty($obj) ? $obj->toArray() : [];
                            $defaultSet = false;
                            foreach ($images as $key => $value) {
                                if ($value['is_default'] == 1) {
                                    $defaultSet = true;
                                    break;
                                }
                            }
                            if ($defaultSet) {
                                $defaultImage = collect($images)->firstWhere('is_default', 1)['image_path'];
                            } else {
                                $defaultImage = $images[0]['image_path'];
                            }
                        @endphp
                        <img src="{{ url('images/product-image') }}/{{ $defaultImage ?? '' }}"
                            style="max-width: 100%; max-height: 100vh; margin: auto;" id="main-image" class="rounded-4 fit" alt="{{ $product->title }}">
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        @foreach ($images as $image)
                            <a onclick="changeImg(this);" data-image="{{ url('images/product-image') }}/{{ $image['image_path'] ?? '' }}" class="border mx-1 rounded-2"  data-type="image"
                                href="javascript:void(0);"
                                class="item-thumb">
                                <img width="60" height="60" class="rounded-2"
                                    src="{{ url('images/product-image') }}/{{ $image['image_path'] ?? '' }}" />
                        @endforeach
                        </a>
                    </div>
                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        
                        <h4 class="title text-dark">
                            {{ $product->title }}
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>
                            <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i>154 orders</span>
                            @if ($product->is_in_stock == 1)
                                <span class="text-success ms-2">In stock</span>
                            @else
                                <span class="text-danger ms-2">Out of stock</span>
                            @endif

                           {{-- <button class="cart-wishlist-btn" data-product-id="{{ $product->id }}">
                                <i
                                    class="{{ auth()->guard('customer')->check() && $product->isInCustomerWishlist() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
							--}}

                        </div>
                        <div class="mb-3">
                            <span class="h5">₹ {{ $product->net_price }}</span>
                            <br>
                            <span class="text-muted">M.R.P.:<del> {{ $product->mrp }}</del></span>

                            {{-- <span class="text-muted">/per box</span> --}}
                        </div>

                        <div class="row mb-4">
                            <dt class="col-3 d-none">Age Group:</dt>
                            <dd class="col-9 d-none">{{ $product->age_group }}</dd>

                            <dt class="col-3">Type:</dt>
                            <dd class="col-9">{{ $product->productType->title }}</dd>

                            <dt class="col-3">Color</dt>
                            <dd class="col-9">{{ $product->color }}</dd>
							
							<dt class="col-3">Description</dt>
                            <dd class="col-9">{!! $product->description !!}</dd>
                        </div>

                        <div class="row">
                            @if ($product->is_size_available == 1)
                                <div class="col-md-6 col-12">
                                    <label class="mb-2">Size</label>
                                    <select name="product-size" id="product-size" class="form-control" onchange="getProductInventory(this.value)">
                                        <option value="">Select a size</option>
                                        @forelse ($productSizes as $size)
                                            <option value="{{$size->id}}">{{$size->size}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            @endif
                            <p id="size-err" class="text-danger"></p>
							<div class="col-md-6 col-12">
								<label class="mb-2 d-block">Quantity</label>
								<div class="input-group mb-3" style="width: 170px;">
									<button class="btn btn-white border border-secondary px-3"
											onclick="changeQty('minus')" type="button" id="button-addon1"
											data-mdb-ripple-color="dark">
										<i class="fas fa-minus"></i>
									</button>
									<input type="text" id="quantity"
										   class="form-control text-center border border-secondary" placeholder="1"
										   aria-label="Example text with button addon" aria-describedby="button-addon1"
										   value="1" min="1" />
									<button class="btn btn-white border border-secondary px-3"
											onclick="changeQty('plus')" type="button" id="button-addon2"
											data-mdb-ripple-color="dark">
										<i class="fas fa-plus"></i>
									</button>
								</div>
							</div>
                        </div>
                        <input type="hidden" name="inventory-qty" id="inventory-qty" value="{{ $product->units_available }}">

                        <div class="row">
                            <div class="col-md-4 col-6 d-none">
                                <label class="mb-2">Size</label>
                                <select class="form-select border border-secondary" style="height: 35px;">
                                    <option>Small</option>
                                </select>
                            </div>
                            @if ($product->is_in_stock == 1)
                                <div class="col-md-4 col-8">
                                    <a href="javascript:" data-url="{{ route('front.cart.add') }}" onclick="addToCart('{{ $product->id }}', {{$product->is_size_available}})"
                                        class="btn btn-primary shadow-0 mt-1">
                                        <i class="me-1 fa fa-shopping-basket"></i> Add to cart </a>
                                </div>
								<div class="col-md-4 col-8">
                                    <button href="javascript:" class="btn btn-danger cart-wishlist-btn" data-product-id="{{ $product->id }}">
                                        <i class="me-1 {{ auth()->guard('customer')->check() && $product->isInCustomerWishlist() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i> Add to Wishlist </button>
                                </div>
                            @endif
                        </div>
                        {{-- <a href="#" class="btn btn-warning shadow-0"> Buy now </a> --}}

                        {{-- <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Save </a> --}}
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
    <script src="{{ asset('js/jquery.picZoomer.js') }}"></script>
    <script>
        $('.picZoomer').picZoomer();
        var addToCartUrl = "{{ route('front.cart.add') }}";
        var getProductInventoryUrl = "{{ route('front.product-inventory') }}";
    </script>
@endsection
