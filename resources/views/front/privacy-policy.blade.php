@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Privacy <span>Policy</span></h2>
            <div class="row">
                {!! $page->content !!}
				{{-- <p>
					Privacy Policy 
At Mom's Moonpie, we respect your privacy and are committed to protecting your personal information. This privacy policy outlines how we collect, use, and safeguard your data.
I.Information Collection:
We collect personal information, such as your name, address, contact details,and payment information, when you place an order from our collection.
2.Use of information:
a.Personal nformation is used solely for the purpose of processing orders managing subscriptions, and providing customisation,if any
b.We may use your contact information to communicate with you about your orders, deliveries, and any updates or promotions related to our collection.
3.Data Security:
a.We implement appropriate security measures to protect your personali nformation from unauthorized access, alteration, disclosure, or destruction.
b.Payment information is processed securely, and we do not: store payment details after the transaction is complete.
4.Data Sharing:
a. We do not share, sell, or disclose your personal information to any third parties, except as required by law or to fulfill our services (e.g, delivery services)
b. Your information is only accessible to authorized personnel who need it to perform their duties.
5.Customer Rights:
a. You have the right to access, update, or delete your personal information at any time. Please contact our customer service team to make any changes.
b. You may opt-out of receiving promotional communications from us by following the unsubscribe instructions in the emails or by contacting our customer service team.
6.Policy Updates
a.We may update this privacy policy from time to time to reflect changes in our practices or legal requirements
b.Customers will be notified of any significant changes via email or our website.
				</p> --}}
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
