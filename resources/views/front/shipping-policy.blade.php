@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Shipping <span>Policy</span></h2>
            <div class="row">
                {!! $page->content !!}
				{{-- <p>
					At Mom's Moonpie, we are committed to delivering best, comfortable and affordable clothing for your babbies promptly and reliably.
Our shipping policy outlines the terms and procedures for the delivery of any orders.
1.Deliveries:
Orders are prepared and dispatched within 3-5 days of receiving the order and we attempt to provide optimum quality upon arrival.
2.Delivery Address:
Deliveries are made to the address specified by the customer at the time of placing an order.
Customers are required to give precise delivery and contact details for a smooth delivery experience.
3.Delivery Issues:
Rest assured that any delivery-related complaints, such as delays, incorrect addresses, or damaged items, will be addressed to the best of our ability via customer care within 24 hours of the scheduled delivery.
4.Contact Information:
Gladly available at care@momsmoonpie.com 
				</p> --}}
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
