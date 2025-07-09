@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Your <span>Wishlist</span></h2>
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (count($wishlistItems) > 0)
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4>Your Cart</h4>
                            </div> --}}
                            <div class="card-body">
                                <b>Wishlist Items</b>
                                <hr>
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Title</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($wishlistItems as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ url('images/product-image') }}/{{ $item->product->productImages->first()->image_path ?? '' }}"
                                                        alt="" height="75" width="100">
                                                </td>
                                                <td>{{ $item->product->title }}</td>
                                                <td>{{ $item->product->net_price }}</td>
                                                <td>
                                                    <form action="{{ route('front.wishlists.remove-item') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class='fas fa-trash-alt'></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h4>Your wishlist is empty!</h4>
                                </center>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
@section('script')
@endsection
