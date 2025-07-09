<!-- resources/views/layouts/front/partials/header.blade.php -->
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="header-top">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img alt="" src="{{ asset('images/logo.png') }}">
                </a>
                <div class="header-top-left">
                    <form role="search" method="get" action="{{ route('front.product-list', '') }}">
                        <input aria-label="Search" placeholder="Search" name="search">
                        <button type="submit">
                            <img alt="" src="{{ asset('images/search-icon.svg') }}">
                        </button>
                    </form>
                    <ul class="header-top-list">
                        @if (Auth::guard('customer')->check())
                            <li>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><img alt=""
                                            src="{{ asset('images/account-icon.svg') }}">Account</a>
                                    <ul class="dropdown-menu" style="background-color:#0e0132;">
                                        <li><a class="dropdown-item" href="{{ route('front.my-account.orders') }}">My
                                                Orders</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.my-account.profile') }}">My
                                                Profile</a>
                                        </li>
                                        {{-- <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.my-account.change-password') }}">Change Password</a>
                                        </li> --}}
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form id="logout-form" action="{{ route('front.customer-logout') }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <aside>
                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </aside>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ route('front.customer-login') }}"><img alt=""
                                        src="{{ asset('images/account-icon.svg') }}">Login</a></li>
                        @endif

                        <li>
                            <a href="{{ route('front.wishlists.index') }}">
                                <img alt="Wishlist" src="{{ asset('images/wishlist-icon.svg') }}">Wishlist</a>
                        </li>
                        <li>
                            <a href="{{ route('front.cart') }}">
                                <img alt="My Cart" src="{{ asset('images/cart-icon.svg') }}">Cart
                                @php
									$cartCount = 0;
									if(auth()->guard('customer')->check()){
										$cartCount = App\Models\CustomerCart::where('customer_id', auth()->guard('customer')->id())->count();
									}else{
										$cartCount = App\Models\CustomerCart::where('session_id', session()->getId())->count();
									}
                                @endphp
                                @if ($cartCount > 0)
                                    <span class="badge badge-danger">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{ route('front.product-list') }}" class="nav-link">Shop</a></li>
                        @forelse (App\Models\Category::where('is_active', 1)->get() as $category)
                            <li class="nav-item"><a href="{{ route('front.product-list', '') }}?catid={{$category->id}}&category={{$category->name}}"
                                class="nav-link">{{$category->name}}</a></li>
                        @empty
                        @endforelse

                        {{-- <li class="nav-item"><a href="{{ route('front.product-list', '') }}?category=just-in-499"
                            class="nav-link">Just in 499</a></li>
                        <li class="nav-item"><a href="{{ route('front.product-list', '') }}?category=shop-for-boys"
                                class="nav-link">Shop for Boys</a></li>
                        <li class="nav-item"><a href="{{ route('front.product-list', '') }}?category=shop-for-girls"
                                class="nav-link">Shop for Girls</a></li>
                        <li class="nav-item"><a href="{{ route('front.product-list', '') }}?category=shop-for-infants"
                                class="nav-link">Shop for Infants</a></li>
                        <li class="nav-item"><a href="{{ route('front.product-list', '') }}?category=gifting"
                                class="nav-link">Gifting</a></li> --}}
                        
                        <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
