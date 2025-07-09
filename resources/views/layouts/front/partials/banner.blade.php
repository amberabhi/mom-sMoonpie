<!-- resources/views/partials/banner.blade.php -->
<section class="banner-section">
    <img alt="" src="{{ asset('images/banner-element1.svg') }}" class="banner-ele-1">
    <img alt="" src="{{ asset('images/banner-element3.svg') }}" class="banner-ele-3">
    <img alt="" src="{{ asset('images/banner-element4.svg') }}" class="banner-ele-4">
    <div class="container">
        <div class="splide banner-splide">
            <div class="splide__track">
                <ul class="splide__list">
                    {{-- @foreach (['1', '2', '3'] as $banner)
                        <li class="splide__slide">
                            <div class="align-items-center banner-row row">
                                <div class="col-lg-5">
                                    <div class="banner-data">
                                        <h1>Comfortable <span>kids-wear</span> for endless fun</h1>
                                        <p>Where comfort meets cuteness. Explore the universe of Mom's Moonpie.</p>
                                        <a href="{{ route('front.product-list') }}" class="comn-btn">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="banner-image">
                                        <img alt="" src="{{ asset('images/banner-element2.svg') }}" class="banner-image-ele">
                                        <div class="banner-image-card-1"><img alt="" src="{{ asset('images/banner-img-'.$banner.'.jpg') }}"></div>
                                        <div class="banner-image-card-2"><img alt="" src="{{ asset('images/banner-img-'.$banner.'.jpg') }}"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach --}}

                    @forelse ($banners as $banner)
                        <li class="splide__slide">
                            <div class="align-items-center banner-row row">
                                <div class="col-lg-5">
                                    <div class="banner-data">
                                        <h1>{{$banner->title}}</h1>
                                        <p>{{$banner->description}}</p>
                                        <a href="{{$banner->cta_url}}" class="comn-btn">{{$banner->cta_text}} <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="banner-image">
                                        <img alt="" src="{{ asset('images/banner-element2.svg') }}" class="banner-image-ele">
                                        <div class="banner-image-card-1"><img alt="banner-image" src="{{ url('images/banner') }}/{{$banner->image_1}}"></div>
                                        <div class="banner-image-card-2"><img alt="banner-image" src="{{ url('images/banner') }}/{{$banner->image_2}}"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</section>
