@extends('layouts.admin.admin-without-nav')
@section('title')
    Login
@endsection
@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="/index" class="text-reset"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50 mb-0">Sign in to continue to Moms Moonpie Backend.</p>
                                <a href="/index" class="logo logo-admin mt-4">
                                    <img src="{{ URL::asset('images/logo.png') }}" alt=""
                                        height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email <span class="text-danger">*
                                            </span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" value="" required
                                            autocomplete="email" autofocus placeholder="Enter email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password <span class="text-danger">*
                                            </span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="userpassword" name="password" required value=""
                                            autocomplete="current-password" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customControlInline"
                                            name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customControlInline">Remember
                                            me</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <div class="mt-4 text-center">
                                            <a href="{{ route('password.request') }}" class="text-muted"><i
                                                    class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                        </div>
                                    @endif
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        {{-- <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Signup
                                now </a> </p> --}}
                        <p>©
                            {{ date('Y') }} Webyou Technologies. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Jay Soni
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
