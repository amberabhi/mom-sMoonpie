<footer>
    <img src="{{ asset('images/banner-element3.svg') }}" class="banner-ele-3" alt="">
    <img src="{{ asset('images/footer-ele-1.svg') }}" class="footer-ele-1" alt="">
    <div class="footer-top">
        <div class="container">
            <div class="footer-top-row">
                <div class="footer-top-card">
                    <img src="{{ asset('images/footer-icon-2.svg') }}" alt="">
                    <aside>Free Shipping Above ₹1499</aside>
                </div>
                <div class="footer-top-card">
                    <img src="{{asset('images/footer-icon-4.svg')}}" alt="">
                    <aside>gift - wrap &#38; ready to give</aside>
                </div>
                <div class="footer-top-card">
                    <img src="{{asset('images/footer-icon-1.svg')}}" alt="">
                    <aside>Easy Free Returns</aside>
                </div>
                <div class="footer-top-card">
                    <img src="{{asset('images/footer-icon-3.svg')}}" alt="">
                    <aside>Secure Payment</aside>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-middle">
            <div class="footer-card">
                <h6 class="footer-title">Categories</h6>
                <ul class="footer-list">
					@forelse (App\Models\Category::where('is_active', 1)->get() as $category)
                            <li class="nav-item"><a href="{{ route('front.product-list', '') }}?catid={{$category->id}}&category={{$category->name}}"
                                class="nav-link">{{$category->name}}</a></li>
                        @empty
                        @endforelse
					<!--
						<li><a href="{{ url('/products?catid=2&category=Shop%20for%20Boys') }}">Shop for Boys</a></li>
						<li><a href="{{ url('/products?catid=2&category=Shop%20for%20Boys') }}">Shop for Girls</a></li>
						<li><a href="{{ url('/products?catid=2&category=Shop%20for%20Boys') }}">Shop for Infants</a></li>
						<li><a href="{{ url('/products?catid=2&category=Shop%20for%20Boys') }}">Gifting</a></li>
					-->
                </ul>
            </div>
            <div class="footer-card">
                <h6 class="footer-title">Information</h6>
                <ul class="footer-list">
                    <li><a href="{{ route('front.shipping-policy') }}">Shipping Policy</a></li>
                    <li><a href="{{ route('front.returns-policy') }}">Returns Policy</a></li>
                    <li><a href="{{ route('front.privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('front.terms-and-conditions') }}">Terms &#38; Conditions</a></li>
                    <li><a href="{{ route('front.contact-us') }}">Contact Us</a></li>
                    <li><a href="{{ route('front.about-us') }}">About Us</a></li>
                </ul>
            </div>
            <div class="footer-card">
                <h6 class="footer-title">My Account</h6>
                <ul class="footer-list">
					@guest('customer')
                    <li><a href="">Log in</a></li>
					@endguest
                    <li><a href="">Refer a Friend</a></li>
                    <li><a href="{{ route('front.my-account.profile') }}">My Profile</a></li>
                    <li><a href="{{ route('front.wishlists.index') }}">My Wishlist</a></li>
                </ul>
            </div>
            <div class="footer-card">
                <a class="navbar-brand" href="index.html"><img src="{{asset('images/logo.png')}}" alt=""></a>
                <h6 class="footer-title">Follow Us</h6>
                <ul class="social-list">
                    <li><a href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} Moms Moonpie. All Rights Reserved</p>
            <img src="{{asset('images/card-image.png')}}" alt="">
        </div>
    </div>
</footer>
