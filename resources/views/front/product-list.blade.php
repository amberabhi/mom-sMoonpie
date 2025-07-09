@extends('layouts.front')

@section('style')
    <style>
        .pagination .text-gray-700 { 
            display: none; 
        }
    </style>
@endsection

@section('content')
    <section class="new-section comn-padding">
        <div class="container">
            <div class="comn-title mb-5 mt-0">
                @empty($category)
                    @empty($searchText)
                        <h2 class="comn-title-text">Our <span>Products</span></h2>
                    @else
                        <h2 class="comn-title-text">Showing Products for: <span> {{ ucwords(str_replace('-', ' ', $searchText)) }} </span></h2>
                    @endempty
                @else
                    <h2 class="comn-title-text">Showing Products for: <span> {{ ucwords(str_replace('-', ' ', $category)) }} </span></h2>
                @endempty
            </div>
            <div class="trending-card text-end mb-2">
                {{-- <button class="comn-btn">view all <i class="fa-solid fa-arrow-right"></i></button> --}}
            </div>
            <div class="new-grid">
                @forelse ($products as $product)
                    <div class="new-card">
                        <button class="wishliat-btn" data-product-id="{{ $product->id }}">
                            <i
                                class="{{ auth()->guard('customer')->check() && $product->isInCustomerWishlist() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                        <a href="{{ route('front.product-details', $product->slug) }}" class="product-link">
                            <div class="new-image">
                                <img src="{{ url('images/product-image') }}/{{ $product->productImages->first()->image_path ?? '' }}"
                                    alt="">
                            </div>
                            <div class="star-row">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                            <h4 class="new-title">{{ $product->title }}</h4>
                            {{-- <aside class="new-price-text">₹{{ $product->net_price }}</aside> --}}
                            <aside class="new-price-text">
                                <span class="h5">₹{{ $product->net_price }}</span>
                                <br>
                                <span class="text-muted">M.R.P.:<del> {{ $product->mrp }}</del></span>
                            </aside>
                        </a>
                    </div>
                @empty
                @endforelse
            </div>

            <!-- Pagination links -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous" tabindex="-1">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                    
                            <!-- Pagination Elements -->
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                    
                            <!-- Next Page Link -->
                            <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection
