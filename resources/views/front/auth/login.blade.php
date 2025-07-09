@extends('layouts.front')
@section('title')
    Checkout | Moms Moonpie
@endsection
@section('style')
@endsection
@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container mt-5">
            <h2 class="mb-4 text-center" style="color: #DE2976;">Login</h2>
            <form action="{{ route('front.customer-login') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Customer Details</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Login Details</b>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success"
                                            style="background-color:#0e0132">Login</button>
                                        <p class="mt-2">New user? <a
                                                href="{{ route('front.customer-register') }}">Register Here</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
@endsection
