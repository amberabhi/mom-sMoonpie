@extends('layouts.front')
@section('title')
    Checkout | Moms Moonpie
@endsection
@section('style')
@endsection
@php
    $user = auth()->guard('customer')->user();
@endphp
@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container mt-5">
            <h2 class="comn-title-text mb-5 text-center">Change <span>Password</span></h2>

            <div class="row mb-4">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <b>Change Password</b>
                            <hr>
                            <form action="{{ route('front.my-account.update-password') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="new_password" class="form-label">New Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password" name="new_password"
                                            required>
                                        @error('new_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation"
                                            required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="submit" style="background-color:#0e0132"
                                            class="btn btn-primary btn-lg w-100">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
@endsection
