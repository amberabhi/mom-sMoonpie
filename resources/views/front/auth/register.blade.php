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
            <h2 class="mb-4 text-center" style="color: #DE2976;">Register</h2>
            <form action="{{ route('front.customer-register') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Customer Details</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Personal Details</b>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">Firstname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            value="{{ old('firstname') }}" required>
                                        @error('firstname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Lastname <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            value="{{ old('lastname') }}" required>
                                        @error('firstname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_number" class="form-label">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number"
                                            value="{{ old('contact_number') }}" required>
                                        @error('contact_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mt-3">
                                        <button type="submit" class="btn btn-success btn-lg w-100"
                                            style="background-color:#0e0132">Register</button>
                                        <p class="mt-2">Already have an account? <a
                                                href="{{ route('front.customer-login') }}">Login Here</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </form>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
@endsection
