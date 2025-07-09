<!-- resources/views/home.blade.php -->
@extends('layouts.front')

@section('content')
    @if (count($banners) > 0)
        @include('layouts.front.partials.banner')
    @endif

    <div class="marqueefy moms-marqueefy" tabindex="0">
        <div class="content">
            @forelse ($marqueeItems as $item)
                <span class="item">{{$item->content}}</span>    
            @empty
            @endforelse
            @forelse ($marqueeItems as $item)
                <span class="item">{{$item->content}}</span>    
            @empty
            @endforelse
            {{-- <span class="item">kids-wear, redefined comfort</span>
            <span class="item">Soft, breathable, and stylish for kids</span>
            <span class="item">Quality kids clothing made in India</span>
            <span class="item">Dress your child in pure Indian comfort</span>
            <span class="item">kids-wear, redefined comfort</span>
            <span class="item">Soft, breathable, and stylish for kids</span>
            <span class="item">Quality kids clothing made in India</span>
            <span class="item">Dress your child in pure Indian comfort</span> --}}
        </div>
    </div>

    <section class="trending-section comn-padding">
        <div class="container">
            <div class="comn-title">
                <h2 class="comn-title-text">Trending <span>Now</span></h2>
                <p class="comn-title-para">for Your Little Ones</p>
            </div>
            <div class="trending-splide splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @php
                            $cardNo = 0;
                        @endphp
                        @forelse ($trendingProducts as $product)
                            @php
                                $cardNo++;
                                if ($cardNo == 4) {
                                    $cardNo = 1;
                                }
                            @endphp
                            <li class="splide__slide">
                                <div class="trending-card trending-card-{{ $cardNo }}">
                                    <div class="trending-image"><img
                                            src="{{ url('images/product-image') }}/{{ $product->productImages->first()->image_path ?? '' }}"
                                            alt=""></div>
                                    <div class="trending-data">
                                        <h4>{{ $product->title }}</h4>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <a href="{{ route('front.product-details', $product->slug) }}" class="comn-btn">Shop Now <i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <div class="splide__arrows splide__arrows_top">
                    <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide"
                        aria-controls="splide01-track"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide"
                        aria-controls="splide01-track"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-section">
        <div class="container">
            <div class="comn-title">
                <h2 class="comn-title-text">Shop By <span>Categories</span></h2>
            </div>
            <div class="shop-grid">
                <div class="shop-card shop-card-1">
                    <div class="shop-image"><img src="{{ asset('images/shop-img-1.png') }}" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Infants</h3>
                        <a href="{{ route('front.product-list', 'shop-for-infants') }}" class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="shop-card shop-card-2 pb-0">
                    <div class="shop-image"><img src="{{ asset('images/shop-img-2.png') }}" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Girls</h3>
                        <a href="{{ route('front.product-list', 'shop-for-girls') }}" class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="shop-card shop-card-3 pb-0">
                    <img src="{{ asset('images/banner-element1.svg"') }} class="banner-ele-1" alt="">
                    <div class="shop-image"><img src="{{ asset('images/shop-img-3.png') }}" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Boys</h3>
                        <a href="{{ route('front.product-list', 'shop-for-boys') }}" class="comn-btn">
                            Shop Now <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="new-section comn-padding">
        <div class="container">
            <div class="comn-title mb-3">
                <h2 class="comn-title-text">New <span>Collection</span></h2>
            </div>
            <div class="trending-card text-end mb-2">
                <a href="{{ route('front.product-list') }}" class="comn-btn">view all <i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="new-grid">
                @forelse ($newCollections as $product)
                    <div class="new-card">
                        <button class="wishliat-btn" data-product-id="{{ $product->id }}">
                            <i class="{{ auth()->guard('customer')->check() && $product->isInCustomerWishlist() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                        <a href="{{ route('front.product-details', $product->slug) }}" class="product-link">
                            <div class="new-image"><img
                                    src="{{ url('images/product-image') }}/{{ $product->productImages->first()->image_path ?? '' }}"
                                    alt=""></div>
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
        </div>
    </section>

    @if (count($testimonials) > 0)
        <section class="customers-section comn-padding">
            <img src="{{ asset('images/customer-ele-1.svg') }}" class="customer-ele-1" alt="">
            <img src="{{ asset('images/customer-ele-2.svg') }}" class="customer-ele-2" alt="">
            <div class="container">
                <div class="comn-title">
                    <h2 class="comn-title-text">What Our Customers <span>Say</span></h2>
                </div>
                <div class="splide customers-splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            @foreach ($testimonials as $testimonial)
                                <div class="splide__slide">
                                    <div class="customers-card">
                                        <i class="fa-solid fa-quote-right"></i>
                                        <img src="{{ url('images/testimonial') }}/{{$testimonial->image}}" alt="{{ $testimonial->customer_name }}">
                                        <div class="star-row">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid {{ $i <= $testimonial->rating ? 'fa-star' : ($i - 0.5 == $testimonial->rating ? 'fa-star-half-stroke' : 'fa-star-outline') }}"></i>
                                            @endfor
                                        </div>
                                        <h3>{{ $testimonial->title }}</h3>
                                        <p>{{ $testimonial->review }}</p>
                                        <h3 class="small-text">{{ $testimonial->customer_name }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="splide__arrows splide__arrows_top">
                        <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide"
                            aria-controls="splide01-track"><i class="fa-solid fa-arrow-left-long"></i></button>
                        <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide"
                            aria-controls="splide01-track"><i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
            </div>
        </section>
    @endif
    
@endsection
@php
    // php global functions here

    function currency(){
        return '₹';
    }
@endphp
@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
