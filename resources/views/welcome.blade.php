<!-- resources/views/home.blade.php -->
@extends('layouts.front')

@section('content')
    @include('layouts.front.partials.banner')

    <div class="marqueefy moms-marqueefy" tabindex="0">
        <div class="content">
            <span class="item">kids-wear, redefined comfort</span>
            <span class="item">Soft, breathable, and stylish for kids</span>
            <span class="item">Quality kids clothing made in India</span>
            <span class="item">Dress your child in pure Indian comfort</span>
            <span class="item">kids-wear, redefined comfort</span>
            <span class="item">Soft, breathable, and stylish for kids</span>
            <span class="item">Quality kids clothing made in India</span>
            <span class="item">Dress your child in pure Indian comfort</span>
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
                        <li class="splide__slide">
                            <div class="trending-card trending-card-1">
                                <div class="trending-image"><img src="images/trending-img-1.png" alt=""></div>
                                <div class="trending-data">
                                    <h4>Playful Designs, Perfect Fit</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="trending-card trending-card-2">
                                <div class="trending-image"><img src="{{ asset('images/trending-img-2.png') }}"
                                        alt=""></div>
                                <div class="trending-data">
                                    <h4>Stylish Clothes for Growing Kids</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="trending-card trending-card-3">
                                <div class="trending-image"><img src="images/trending-img-3.png" alt=""></div>
                                <div class="trending-data">
                                    <h4>Comfort Meets Cute in Every Piece</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="trending-card trending-card-1">
                                <div class="trending-image"><img src="images/trending-img-1.png" alt=""></div>
                                <div class="trending-data">
                                    <h4>Playful Designs, Perfect Fit</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="trending-card trending-card-2">
                                <div class="trending-image"><img src="images/trending-img-2.png" alt=""></div>
                                <div class="trending-data">
                                    <h4>Stylish Clothes for Growing Kids</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="trending-card trending-card-3">
                                <div class="trending-image"><img src="images/trending-img-3.png" alt=""></div>
                                <div class="trending-data">
                                    <h4>Comfort Meets Cute in Every Piece</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pretium felis et ornare
                                        aliquet.</p>
                                </div>
                                <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </li>
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
                    <div class="shop-image"><img src="images/shop-img-1.png" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Infants</h3>
                        <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="shop-card shop-card-2 pb-0">
                    <div class="shop-image"><img src="images/shop-img-2.png" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Girls</h3>
                        <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="shop-card shop-card-3 pb-0">
                    <img src="images/banner-element1.svg" class="banner-ele-1" alt="">
                    <div class="shop-image"><img src="images/shop-img-3.png" alt=""></div>
                    <div class="shop-data">
                        <h3 class="comn-title-text">Shop For Boys</h3>
                        <button class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></button>
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
                <button class="comn-btn">view all <i class="fa-solid fa-arrow-right"></i></button>
            </div>
            <div class="new-grid">
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-1.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">Classic Printed Pajama Set</h4>
                    <aside class="new-price-text">₹899</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-2.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">Multi color flower print T-shirt</h4>
                    <aside class="new-price-text">₹1299</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-3.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">Blue color Animal printed baby pillow</h4>
                    <aside class="new-price-text">₹499</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-4.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">infant swaddle blanket/sleeping bag</h4>
                    <aside class="new-price-text">₹1680</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-5.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">Classic Printed Pajama Set</h4>
                    <aside class="new-price-text">₹770</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-6.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">infant car seat cushion</h4>
                    <aside class="new-price-text">₹930</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-7.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">baby girl tutu dress</h4>
                    <aside class="new-price-text">₹1820</aside>
                </div>
                <div class="new-card">
                    <button class="wishliat-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="new-image"><img src="images/new-img-8.png" alt=""></div>
                    <div class="star-row">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h4 class="new-title">Designer Girls Baby Frock</h4>
                    <aside class="new-price-text">₹1820</aside>
                </div>
            </div>
        </div>
    </section>



    <section class="customers-section comn-padding">
        <img src="images/customer-ele-1.svg" class="customer-ele-1" alt="">
        <img src="images/customer-ele-2.svg" class="customer-ele-2" alt="">
        <div class="container">
            <div class="comn-title">
                <h2 class="comn-title-text">What Our Customers <span>Say</span></h2>
            </div>
            <div class="splide customers-splide">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div class="customers-card">
                                <i class="fa-solid fa-quote-right"></i>
                                <img src="images/customer-img-1.jpg" alt="">
                                <div class="star-row">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <h3>Amazing Fabric</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas imperdiet ipsum,
                                    eget eleifend libero suscipit vel. Mauris sit amet vehicula nibh.</p>
                                <h3 class="small-text">Anaya</h3>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="customers-card">
                                <i class="fa-solid fa-quote-right"></i>
                                <img src="images/customer-img-2.jpg" alt="">
                                <div class="star-row">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <h3>Amazing Fabric</h3>
                                <p>Fusce id venenatis libero, tempor rhoncus nunc. Sed eget neque odio. In eu rhoncus
                                    ligula. Fusce augue dolor, luctus et lorem nec, iaculis fringilla nibh. </p>
                                <h3 class="small-text">Kabir</h3>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="customers-card">
                                <i class="fa-solid fa-quote-right"></i>
                                <img src="images/customer-img-1.jpg" alt="">
                                <div class="star-row">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <h3>Amazing Fabric</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas imperdiet ipsum,
                                    eget eleifend libero suscipit vel. Mauris sit amet vehicula nibh.</p>
                                <h3 class="small-text">Anaya</h3>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="customers-card">
                                <i class="fa-solid fa-quote-right"></i>
                                <img src="images/customer-img-2.jpg" alt="">
                                <div class="star-row">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                </div>
                                <h3>Amazing Fabric</h3>
                                <p>Fusce id venenatis libero, tempor rhoncus nunc. Sed eget neque odio. In eu rhoncus
                                    ligula. Fusce augue dolor, luctus et lorem nec, iaculis fringilla nibh. </p>
                                <h3 class="small-text">Kabir</h3>
                            </div>
                        </div>
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
@endsection
