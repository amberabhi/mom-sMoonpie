<!-- resources/views/layouts/front.blade.php -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Moms Moonpie')</title>
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/marqueefy.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    @include('layouts.front.partials.header')

    <!-- Main Content -->
    @yield('content')

    @include('layouts.front.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script src="{{ asset('js/marqueefy.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        var loggedin = {{ auth()->guard('customer')->check() ? 'true' : 'false' }};
    </script>

    <script>
        $('.wishliat-btn, .cart-wishlist-btn').on('click', function() {
            if (!loggedin) {
                window.location.href = "{{ route('front.customer-login') }}";
            }
            const productId = $(this).data('product-id');
            const $icon = $(this).find('i');
            const isAdding = $icon.hasClass('fa-regular');
            const url = isAdding ? "{{ route('front.wishlists.add') }}" :
                "{{ route('front.wishlists.remove') }}";

            $.ajax({
                url: url,
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({
                    product_id: productId
                }),
                success: function(data) {
                    if (data.status === 'success') {
                        $icon.toggleClass('fa-regular fa-solid');
                        alert(data.message);
                        // toastr.success(data.message);
                    }
                }
            });
        });
    </script>
    @yield('script')
</body>

</html>
